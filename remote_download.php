<?php
file_put_contents( 'progress.txt', '' );
if(is_file("progress.txt")){ unlink("progress.txt"); }
if(is_file("testfile.iso")){ unlink("testfile.iso"); }
$targetFile = fopen( 'testfile.iso', 'w' );
$ch = curl_init( 'https://speed.hetzner.de/100MB.bin' );
curl_setopt( $ch, CURLOPT_PROGRESSFUNCTION, 'progressCallback' );
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt( $ch, CURLOPT_NOPROGRESS, false );

curl_setopt( $ch, CURLOPT_FILE, $targetFile );
curl_exec( $ch );
fclose( $targetFile );
function progressCallback ($resource, $download_size, $downloaded_size, $upload_size, $uploaded_size)
{
    static $previousProgress = 0;
    
    if ( $download_size == 0 )
        $progress = 0;
    else
        $progress = round( $downloaded_size * 100 / $download_size );
    
    if ( $progress > $previousProgress)
    {
        $previousProgress = $progress;
        $fp = fopen( 'progress.txt', 'a' );
        fputs( $fp, "$progress\n" );
        fclose( $fp );
    }
}
?>