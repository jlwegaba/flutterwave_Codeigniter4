<?php

namespace App\Controllers\Payments;

use CodeIgniter\Controller;

require_once ROOTPATH . "vendor/autoload.php";

use App\Controllers\BaseController;
use Flutterwave\EventHandlers\EventHandlerInterface;
use Flutterwave\Flutterwave;
use App\Models\SettingsModel;
use App\Models\TransactionsModel;

Flutterwave::bootstrap();



class Payments extends BaseController
{

    public $subscriptionModel;
    public function __construct()
    {
        parent::init();

        $this->transactionsModel                = new TransactionsModel();
		
		//Start Curl Services in codeigniter 4
        $this->client = \Config\Services::curlrequest();
        
        //Get required paramenters for the process & unique transaction token.
        $this->token = bin2hex(random_bytes(18));
		
        //Success link to connect to redirected Flutterwave link and help process results in your ci4 system.
        $this->success_url = base_url('clientarea/success/page/');

        //Flutterwave connection credentials
        $this->publicKey      = getenv('PUBLIC_KEY');
        $this->secretKey      = getenv('SECRET_KEY');
        $this->encryptionKey  = getenv('ENCRYPTION_KEY');
        $this->env            = getenv('ENV');
        $this->currency       = 'UGX';
        $this->prefix         = 'fw';
        $this->overrideRef    = false;
 
    }
	
	public function index()
	{
		//Displays the payment form with data to be submitted for payment.
		
		return view('pay/index', $this->data);
	}
 
   

/*** ====================================================================================================
 * FLUTTERWAVE 
 =======================================================================================================*/
    //Flutterwave payment
    public function flutterWave()
    {

        // Set the API endpoint URL
        $url = 'https://api.flutterwave.com/v3/payments';

        // Set the request headers
        $headers = [
            'Authorization' => 'Bearer ' . getenv('SECRET_KEY'),
            'Content-Type'  => 'application/json',
        ];

        // Set the request payload
        $payload = [
            'tx_ref'            => $this->token,
            'amount'            => $this->request->getPost('amount'),
            'currency'          => $this->currency,
            'redirect_url'      => $this->success_url,
            'customer'          => [
                'email'         => $this->request->getPost('email'),
                'firstname'     => $this->request->getPost('firstname'),
                'lastname'      => $this->request->getPost('lastname'),
                'phonenumber'   => $this->request->getPost('phonenumber'),
            ],
            'meta'              => [
                    'consumer_id'   => $this->tenantId->tenant_id,
            ],
            'customizations'     => [
                    'title'       => $this->request->getPost('title'),
                    'logo'        => $this->request->getPost('logo'),
                    'description' => $this->request->getPost('description'),
            ],
            'payment_plan'         => $this->user->subscription_period,
        ];

        //Saving Transaction Details in DB
        $fname = $this->request->getPost('firstname');
        $lname = $this->request->getPost('lastname');

        $transData = [
            'user_id'                       => $this->tenantId->user_id,
            'currency'                      => $this->currency,
            'payment_ref'             		=> $this->token,
            'amount'                        => $this->request->getPost('amount'),
            'payment_gateway'               => 'Flutterwave',
            'customer_name'                 => $fname.' '.$lname,
            'customer_email'                => $this->request->getPost('email'),
            'customer_phone'                => $this->request->getPost('phonenumber'),
            'description'                   => $this->request->getPost('description'),
            'invoice_id'                    => $invoice->id, //This is option as per your App setting
            'status'                        => 'pending',
        ];
        $this->transactionsModel->save($transData);

        // Convert the payload to JSON
        $jsonPayload = json_encode($payload);

        try {
            // Make a POST request to the API endpoint
            $response = $this->client->request('POST', $url, [
                'headers' => $headers,
                'body' => $jsonPayload
            ]);

            // Get the response body as JSON
            $responseJson = json_decode($response->getBody(), true);
            //var_dump($responseJson);
            
            // If the payment was successfully initialized, redirect the user to the payment page
            if (isset($responseJson['status']) && $responseJson['status'] == 'success') {
                return redirect()->to($responseJson['data']['link']);
            }
            

        } catch (\Exception $e) {
            // Handle any errors that occur during the request
            echo $e->getCode() . ' ' . $e->getMessage();
        }

    }

    //update Transaction Table after Flutterwave payments
    public function successLink()
    {
        //Details coming from payment Flutterwave payment Link
        $transactionId = $this->request->getGet('transaction_id');
        $status = $this->request->getGet('status');
        $tx_ref = $this->request->getGet('tx_ref');

		//Get Transactions ID to help update record in Db.
        $transactionDetails = $this->transactionsModel->where('payment_ref', $tx_ref)->first($tx_ref);
        //var_dump($transactionDetails);


        //Updating the Transactions Table with transaction Id, status, tx_ref
        $tData = [
            'transaction_id'        => $transactionId,
            'status'                => $status,
            'payment_ref'     		=> $tx_ref
        ];
        $forInvoice = $this->transactionsModel->update($transactionDetails['id'], $tData);
		
		//Display Transaction details into success page
		$this->data['details'] = $this->transactionsModel->getUserPaymentDetails($transactionDetails['id'])

        if($forInvoice)
		{
                // Send a success response back to Flutterwave
                if($this->request->isAJAX())
                {
                    $response = [
                            //'success' => true,
                            'status' => 'success',
                            'msg' =>'Payment was successful',	   
                    ];
                    return $this->response->setJSON($response);
                }else{
                    $this->session->setFlashdata('success', 'Payment was successful', 3);
                    return redirect()->to('clientarea/success/page'); 
                }
        }

        return view('pay/success_page', $this->data);
    }

}
