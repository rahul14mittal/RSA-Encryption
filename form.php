
<?php
//myRSA Class Source: https://ebckurera.wordpress.com/2017/06/22/rsa-cryptography-in-php-how-to/

include('Crypt/RSA.php');
 
class myRSA
{
    public static $privateKey = '';
    public static $publicKey = '';
    public static $keyPhrase = '';
     
    public static function createKeyPair()
    {
        $rsa = new Crypt_RSA();
        $password = base64_encode(sha1(time().rand(100000,999999)));
        $rsa->setPassword($password );
        $keys=$rsa->createKey(2048);     
        myRSA::$privateKey=$keys['privatekey'];
        myRSA::$publicKey=$keys['publickey'];
        myRSA::$keyPhrase=$password;
    }
 
    public static function encryptText($text)
    {
        $rsa = new Crypt_RSA();
        $rsa->loadKey(myRSA::$publicKey);
        $encryptedText = $rsa->encrypt($text);
        return $encryptedText;
    }
 
    public static function decryptText($encryText)
    {
        $rsa = new Crypt_RSA();
        $rsa->setPassword(myRSA::$keyPhrase);
        $rsa->loadKey(myRSA::$privateKey);
        $plaintext = $rsa->decrypt($encryText);
        return $plaintext;
    }
}
?>


<html>
    <head>
        <title> RSA Encryption </title>
</head>
    <body>
        <h3>RSA Encryption using PHP</h3>
        <h5>CNT 4713 - Summer 2019 (Rahul Mittal) </h5>
    
        <form action="form.php" method="GET">
            <input type = "submit" value = "Refresh" name = "refresh">
            <p><h4>Input</h4></p> <input type="text" name="text">
            <input type="submit" value="Encrypt" name = "submit"><br>
            <?php
                if ( isset( $_GET['submit'] ) ) {
                $text = $_GET['text'];
                echo $text;
                myRSA::createKeyPair(1024);
                $secureText = myRSA::encryptText($text);
                $decrypted_text =  myRSA::decryptText($secureText);
            ?>
                    <p>Encrypted Text</p><textArea disabled><?php echo $secureText; ?></textArea>
                    <p>Decrypted Text</p><textArea disabled><?php echo $decrypted_text; ?></textArea>
            <?php
                }
            ?>
        
        </form>
    </body>
</html>

