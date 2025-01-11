<?php

require_once('vendor/autoload.php');

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Label\LabelAlignment;
use Endroid\QrCode\Label\Font\OpenSans;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;

if (isset($_POST['submit'])) {
    $qr = $_POST['qr'];
}

$builder = new Builder(
    writer: new PngWriter(),
    writerOptions: [],
    validateResult: false,
    data: $qr,
    encoding: new Encoding('UTF-8'),
    errorCorrectionLevel: ErrorCorrectionLevel::High,
    size: 300,
    margin: 10,
    roundBlockSizeMode: RoundBlockSizeMode::Margin,
    logoResizeToWidth: 50,
    logoPunchoutBackground: true,
    labelText: 'QR CODE',
    labelFont: new OpenSans(20),
    labelAlignment: LabelAlignment::Center
);

$result = $builder->build();

// Directly output the QR code
header('Content-Type: '.$result->getMimeType());
echo $result->getString();

// Save it to a file
$result->saveToFile(__DIR__.'/qrcode.png');

// Generate a data URI to include image data inline (i.e. inside an <img> tag)
$dataUri = $result->getDataUri();

?>