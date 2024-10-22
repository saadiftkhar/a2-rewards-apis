<?php
require 'config/index.php';

$title = !empty($_GET['title']) ? $_GET['title'] : null;
$body = !empty($_GET['body']) ? $_GET['body'] : "";
$clientTopic = !empty($_GET['client_topic']) ? $_GET['client_topic'] : "";

function setConnection1() {
	
	$client = new Client();
	$client -> setApiKey("AAAAx4a8Vrs:APA91bGBxftmAO0si7CAGknH8kMZJYIl3MpB7Snu_UvRn0C28A0FCAOavCKZ68OeOBNsVaWSp7Myk07UyhYgIwVCmYBkZpeoVfKlOqiCUKptCSJ-gt9Y6OzV8f35iMRs1tVfPCPsRBfo");
	$client -> injectGuzzleHttpClient(new GuzzleHttpClient());

}

function sendNotification(
    Client $client,
    string $title,
    string $body,
    string $clientTopic) : void {
 
    $message = new Message();
 
    $message -> setNotification(
        new Notification(
            $title,
            $body
        )
    );
 
    foreach ($clientTokens as $clientToken) {
        $message -> addRecipient(new Device($clientTopic));
    }
 
    $client -> send($message);
 
}