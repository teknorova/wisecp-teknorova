<?php
/**
 * Created by PhpStorm.
 * User: bunyaminakcay
 * Project name whmcs-dna
 * 13.03.2024 15:02
 * Bünyamin AKÇAY <bunyamin@bunyam.in>
 */

/**
 * Class Teknorova
 * @package Teknorova
 * @version 1.0.0
 */

namespace Teknorova;

class Teknorova {

    /**
     * @var mixed
     */
    private $endpoint, $request, $response,$token;


    public function __construct($token) {

        $this->setToken($token);

    }


    /**
     * Get Current account details with balance
     */
    public function GetResellerDetails() {

        $my_stats =  $this->request('GET','me');

        return $my_stats;
    }


    /**
     * Check Availability , SLD and TLD must be in array
     * @param array $Domains
     * @param array $TLDs
     * @param int $Period
     * @param string $Command
     * @return array
     */
    public function CheckAvailability($Domains, $TLDs, $Period, $Command=null) {

        $check = $this->request('POST','check',[
            'sld'=>$Domains,
            'tld'=>$TLDs
        ]);
        $available=[];

         foreach ($check as $name => $value) {

                $available[] = [
                    "TLD"        => $value["Tld"],
                    "DomainName" => $value["DomainName"],
                    "Status"     => $value["Status"],
                    "Command"    => $value["Command"],
                    "Period"     => $value["Period"],
                    "IsFee"      => $value["IsFee"],
                    "Price"      => $value["Price"],
                    "Currency"   => $value["Currency"],
                    "Reason"     => $value["Reason"],
                ];

            }

         return $available;

    }

    /**
     * Get Domain List 0f your account
     * @return array
     */
    public function GetList($extra_parameters=[]) {

        $qs = [];

        if(isset($extra_parameters['PageNumber'])){
            $qs['page'] = $extra_parameters['PageNumber'];
        }

        $domainlist = $this->request('GET','domain/list',$qs);

        return $domainlist;
    }

    /**
     * Return tld list and pricing matrix , required for price and tld sync
     * @param int $count
     */
    public function GetTldList() {

        $tldlist = $this->request('GET','tld/list',[]);

        return $tldlist;
    }

    /**
     * Get Domain details
     * @param string $DomainName
     * @return array
     */
    public function GetDetails($DomainName) {

        $detail = $this->request('GET','domain/'.$DomainName);

        return $detail;
    }

    /**
     * Modify Name Server, Nameservers must be valid array
     * @param string $DomainName
     * @param array $NameServers
     * @return array
     */
    public function ModifyNameServer($DomainName, $NameServers) {

        $ns_change = $this->request('POST','domain/nameservers/'.$DomainName,[
            'nameservers'=>$NameServers
        ]);

        return $ns_change;
    }


    /**
     * Enable Theft Protection Lock for domain
     * @param string $DomainName
     * @return array
     */
    public function EnableTheftProtectionLock($DomainName) {

        $enable_theft = $this->request('POST','domain/lock/'.$DomainName);

        return $enable_theft;
    }


    /**
     * Disable Theft Protection Lock for domain
     * @param string $DomainName
     * @return array
     */
    public function DisableTheftProtectionLock($DomainName) {

        $disable_theft = $this->request('DELETE','domain/lock/'.$DomainName);

        return $disable_theft;
    }

    // CHILD NAMESERVER MANAGEMENT

    /**
     * Add Child Name Server for domain
     * @param string $DomainName
     * @param string $NameServer
     * @param string $IPAdresses
     * @return array
     */
    public function AddChildNameServer($DomainName, $NameServer, $IPAdresses) {


        $add_child = $this->request('POST','domain/child-nameserver/'.$DomainName,[
            'nameservers'=>[
                'name'=>$NameServer,
                'ip'=>$IPAdresses
            ]
        ]);


        return $add_child;


    }


    /**
     * Delete Child Name Server for domain
     * @param string $DomainName
     * @param string $NameServer
     * @return array
     */
    public function DeleteChildNameServer($DomainName, $NameServer) {

        $delete_child = $this->request('DELETE','domain/child-nameserver/'.$DomainName.'?nameserver='.$NameServer);

        return $delete_child;

    }


    /**
     * Modify IP of Child Name Server for domain
     * @param string $DomainName
     * @param string $NameServer
     * @param string $IPAdresses
     * @return array
     */
    public function ModifyChildNameServer($DomainName, $NameServer, $IPAdresses) {


        $modify_child = $this->request('PUT', 'domain/child-nameserver/' . $DomainName, [
            'nameserver' => $NameServer,
            'ip'         => $IPAdresses
        ]);

        return $modify_child;
    }

    // CONTACT MANAGEMENT

    /**
     * Get Contacts for domain, Administrative, Billing, Technical, Registrant segments will be returned
     * @param string $DomainName
     * @return array
     */
    public function GetContacts($DomainName) {


        $contact = $this->request('GET','domain/contact/'.$DomainName);

        return $contact;
    }


    /**
     * Save Contacts for domain, Contacts segments will be saved as Administrative, Billing, Technical, Registrant.
     * @param string $DomainName
     * @param array $Contacts
     * @return array
     */
    public function SaveContacts($DomainName, $Contacts) {

        $save_contact = $this->request('put','domain/contact/'.$DomainName,[
            'contacts'=>$Contacts
        ]);

        return $save_contact;
    }

    // DOMAIN TRANSFER (INCOMING DOMAIN)

    // Start domain transfer (Incoming domain)

    /**
     * Transfer Domain
     * @param string $DomainName
     * @param string $AuthCode
     * @param int $Period
     * @return array
     */
    public function Transfer($DomainName, $AuthCode, $Period) {

        $transfer = $this->request('POST','domain/transfer/',[
            'domain'=>$DomainName,
            'secret'=>$AuthCode,
            'year'=>$Period
        ]);

        return $transfer;
    }



    /**
     * Renew domain
     * @param string $DomainName
     * @param int $Period
     * @return array
     */
    public function Renew($DomainName, $Period) {


        $renew = $this->request('POST','domain/renew/'.$DomainName,[
            'period'=>$Period
        ]);

        return $renew;
    }


    // Register domain with contact information
    /**
     * Register domain with contact information
     * @param string $DomainName
     * @param int $Period
     * @param array $Contacts
     * @param array $NameServers
     * @param bool $TheftProtectionLock
     * @param bool $PrivacyProtection
     * @param array $addionalAttributes
     * @return array
     */
    public function RegisterWithContactInfo($DomainName, $Period, $Contacts, $NameServers = ["ns1.teknorova.com", "ns2.teknorova.com"],  $TheftProtectionLock = true, $PrivacyProtection = false,$addionalAttributes=[]) {

        $addionals = [];

        if (count($addionalAttributes) > 0) {
            foreach ($addionalAttributes as $k => $v) {
                $addionals[] = ['Key'   => $k,
                                'Value' => $v
                ];
            }
        }


        $register = $this->request('POST', 'domain/register/', [
            "domain"                => $DomainName,
            "year"                  => $Period,
            "contact_info"          => [
                "Administrative" => $Contacts["Administrative"],
                "Billing"        => $Contacts["Billing"],
                "Technical"      => $Contacts["Technical"],
                "Registrant"     => $Contacts["Registrant"]
            ],
            "nameserver_info"       => $NameServers,
            "thieft_protection"     => $TheftProtectionLock,
            "privacy_protection"    => $PrivacyProtection,
            "additional_attributes" => $addionals

        ]);

        return $register;


    }


    // Modify privacy protection status of domain
    /**
     * Modify privacy protection status of domain
     * @param string $DomainName
     * @param bool $Status
     * @param string $Reason
     * @return array
     */
    public function ModifyPrivacyProtectionStatus($DomainName, $Status, $Reason = "Owner request") {

        $method = $Status ? 'POST' : 'DELETE';
        $privacy = $this->request($method,'domain/privacy/'.$DomainName,[]);

        return $privacy;
    }


    /**
     * Sync from registry, domain information will be updated from registry
     * @param string $DomainName
     * @return array
     */
    public function SyncFromRegistry($DomainName) {

        return $this->request('PUT','domain/'.$DomainName,[]);

    }


    /**
     * Domain is TR type
     * @param $domain
     * @return bool
     */
    public function isTrTLD($domain){
        //preg_match('/\.com\.tr|\.net\.tr|\.org\.tr|\.biz\.tr|\.info\.tr|\.tv\.tr|\.gen\.tr|\.web\.tr|\.tel\.tr|\.name\.tr|\.bbs\.tr|\.gov\.tr|\.bel\.tr|\.pol\.tr|\.edu\.tr|\.k12\.tr|\.av\.tr|\.dr\.tr$/', $domain, $result);

        preg_match('/\.tr$/', $domain, $result);



        return isset($result[0]);
    }




    public function setToken($token) {
        $this->token = $token;
        return $this;
    }


    public function getToken() {
        return $this->token;
    }


    public function getRequest() {
        return $this->request;
    }

    public function setRequest($request) {
        $this->request = $request;
    }

    public function getResponse() {
        return $this->response;
    }

    public function setResponse($response) {
        $this->response = $response;
    }

    public function getEndpoint() {
        return $this->endpoint;
    }

    public function setEndpoint($endpoint) {
        $this->endpoint = $endpoint;
    }


    public function request($method, $endpoint, $data = []) {

        $url = 'https://api-gateway.bunyam.in/api/' . $endpoint;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

        if (in_array($method, ['GET', 'DELETE'])) {
            if(!empty($data)){
                $url .= '?' . http_build_query($data);
            }
        } else {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: text/plain',
            'AccessToken: ' . $this->getToken(),
        ]);





        $response = curl_exec($ch);
        $response_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $response = json_decode($response, true);
        $response['status_code'] = $response_status;


        $this->setRequest($data);
        $this->setResponse($response);
        $this->setEndpoint($endpoint);


        $response['status_code'] = $response_status;

        if ($response_status >= 200 && $response_status <= 299) {
            // Başarılı
            $response['success'] = true;
        } elseif (curl_errno($ch)) {
            // Fatal CURL error
            $response['success'] = false;
            $response['error']   = 'Comminication error: ' . curl_error($ch);
        } else {
            // 200-299 arası değilse, yani başarılı bir HTTP durumu değilse
            $response['success']     = false;
            $response['http_status'] = $response_status;
        }

        return $response;

    }



}
