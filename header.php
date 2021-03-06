<?php
declare(strict_types=1);
require_once('../../config/minterapi/vendor/autoload.php');
use Minter\MinterAPI;
use Minter\SDK\MinterTx;
use Minter\SDK\MinterCoins\MinterMultiSendTx;

function TransactionSend($api,$address,$private_key,$chainId,$gasCoin,$text,$tx_array)
{
	$api = new MinterAPI($api);
	if ($chainId == 1) 
		{
			$tx = new MinterTx([
				'nonce' => $api->getNonce($address),
				'chainId' => MinterTx::MAINNET_CHAIN_ID,
				'gasPrice' => 1,
				'gasCoin' => $gasCoin,
				'type' => MinterMultiSendTx::TYPE,
				'data' => [
					'list' => $tx_array
				],
				'payload' => $text,
				'serviceData' => '',
				'signatureType' => MinterTx::SIGNATURE_SINGLE_TYPE
			]);
		} 
	else 
		{
			$tx = new MinterTx([
				'nonce' => $api->getNonce($address),
				'chainId' => MinterTx::TESTNET_CHAIN_ID,
				'gasPrice' => 1,
				'gasCoin' => $gasCoin,
				'type' => MinterMultiSendTx::TYPE,
				'data' => [
					'list' => $tx_array
				],
				'payload' => $text,
				'serviceData' => '',
				'signatureType' => MinterTx::SIGNATURE_SINGLE_TYPE
			]);
		}
	$transaction = $tx->sign($private_key);
	return $api->send($transaction)->result;
}
//-----------------------
$base = $_SERVER['DOCUMENT_ROOT'] . '/explorer/session.txt';
include($_SERVER['DOCUMENT_ROOT'] . '/explorer/online.php');
//-----------------------

$session_language = $_SESSION['session_language'];
$version = explode('public_html', $_SERVER['DOCUMENT_ROOT'])[1];
if ($version == 'testnet') {require_once($_SERVER['DOCUMENT_ROOT'] . 'config/config.php');}
else {require_once(explode('public_html', $_SERVER['DOCUMENT_ROOT'])[0] . 'config/config.php');}
require_once($_SERVER['DOCUMENT_ROOT'] . '/function.php');

$cript_mnemonic = $_SESSION['cript_mnemonic'];
if ($cript_mnemonic != '') {
$decript_text = openssl_decrypt($cript_mnemonic, $crypt_method, $crypt_key, $crypt_options, $crypt_iv);
$decript = json_decode($decript_text,true);

$address = $decript['address'];
$private_key = $decript['private_key'];
ob_start();

$db_cats = new dbCats();

$nick = User::Address($address)->nick;
$check_language = User::Address($address)->language;

if ($check_language != '') {$Language = Language($check_language);}
elseif ($session_language != '') {$Language = Language($session_language);} 
else {$Language = Language('English');}

$balance = CoinBalance($address, 'MINTERCAT');
//-------------------------------
}else{header_lol($site.'exit.php');}
$url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
echo "
<!DOCTYPE html>
<html lang='en'>

<head>
<title>MinterCat | $nick</title>

<meta charset='utf-8'>
<link rel='shortcut icon' href='".$site."static/img/icons/Cats.webp'>
<link rel='stylesheet' href='".$site."static/css/styles.min.css'>
<link rel='stylesheet' href='".$site."static/css/style_header.css'>
<link rel='stylesheet' href='".$site."static/css/style_menu.css'>
<link rel='stylesheet' href='".$site."static/css/pagination.css'>
<link rel='stylesheet' href='".$site."static/css/lk.css'>
<link rel='stylesheet' href='".$site."static/css/social.css'>
<script src='".$site."static/js/dragndrop/jquery-3.4.1.min.js'></script>
<link rel='stylesheet' href='".$site."static/css/normalize.css'>
<meta name='viewport' content='width=device-width, initial-scale=1'>
</head>

<body>
	<div class='cat_header'>
  <svg display='none'>

    <symbol id='close-icon' viewBox='0 0 22 23'>
      <path
        d='M1.362 22.345l-.724-.69 9.42-9.89L.646 2.354l.708-.708 9.393 9.394L20.637.655l.725.69-9.907 10.403 9.899 9.898-.708.708-9.881-9.882z' />
    </symbol>

    <symbol id='illustration' viewBox='0 0 214.72 63.15'>
      <path d='M121.47,21.05h14.75c5.81,0,10.53-4.71,10.53-10.53S142.02,0,136.21,0H26.59
        c-5.81,0-10.53,4.71-10.53,10.53s4.71,10.53,10.53,10.53h48.46c5.81,0,10.53,4.71,10.53,10.53c0,5.81-4.71,10.53-10.53,10.53H58.56
        c-5.81,0-10.53,4.71-10.53,10.53c0,5.81,4.71,10.53,10.53,10.53h68.61c5.81,0,10.53-4.71,10.53-10.53
        c0-5.81-4.71-10.53-10.53-10.53h-5.71c-5.81,0-10.53-4.71-10.53-10.53C110.94,25.76,115.65,21.05,121.47,21.05z' />
      <path d='M214.72,10.93c0,6.04-4.89,10.93-10.93,10.93h-31.47c-6.04,0-10.93-4.89-10.93-10.93l0,0
        c0-6.04,4.89-10.93,10.93-10.93h31.47C209.82,0,214.72,4.89,214.72,10.93L214.72,10.93z' />
      <path d='M32.13,52.63c0,5.81-4.89,10.53-10.93,10.53H10.93C4.89,63.15,0,58.44,0,52.63l0,0
        C0,46.81,4.89,42.1,10.93,42.1H21.2C27.24,42.1,32.13,46.81,32.13,52.63L32.13,52.63z' />
    </symbol>

  </svg>

  <div class='page page--profile'>
    <header class='top-header'>
      <div class='container'>
        <div class='top-header__inner'>

          <a href='#' class='logo top-header__logo'>
            <svg version='1.1' class='logo__img' xmlns='http://www.w3.org/2000/svg'
              xmlns:xlink='http://www.w3.org/1999/xlink' x='0px' y='0px' viewBox='0 0 42.36 42.23'
              enable-background='new 0 0 42.36 42.23' xml:space='preserve'>
              <g>
                <circle fill='#FFFFFF' cx='21.11' cy='21.11' r='21.11' class='logo__circle' />
                <g>
                  <defs>
                    <circle id='SVGID_1_' cx='21.25' cy='21.11' r='21.11' />
                  </defs>
                  <clipPath id='SVGID_2_'>
                    <use xlink:href='#SVGID_1_' overflow='visible' />
                  </clipPath>
                  <g clip-path='url(#SVGID_2_)'>
                    <path fill='#1F2224' d='M12.25,8.4c0.29-1.1-9.79,34.57-5.13,44.21c3.54,7.33,24.52,9.66,28.48-0.1s-4.88-45-4.88-45l-5.8,5.03
          l-6.43,0.37L12.25,8.4z' />
                    <line fill='#FFFFFF' stroke='#FFFFFF' stroke-width='0.5' stroke-miterlimit='10' x1='25.1' y1='24.23'
                      x2='30.83' y2='22.35' />
                    <line fill='#FFFFFF' stroke='#FFFFFF' stroke-width='0.5' stroke-miterlimit='10' x1='25.1' y1='26.23'
                      x2='31.66' y2='25.55' />
                    <line fill='#FFFFFF' stroke='#FFFFFF' stroke-width='0.5' stroke-miterlimit='10' x1='11.39'
                      y1='22.47' x2='17.6' y2='24.14' />
                    <line fill='#FFFFFF' stroke='#FFFFFF' stroke-width='0.5' stroke-miterlimit='10' x1='11.47'
                      y1='25.52' x2='17.71' y2='26.17' />
                    <polygon fill='#FFFFFF' points='26.64,13.25 29.51,10.68 29.91,13.73 			' />
                    <polygon fill='#FFFFFF' points='12.85,13.39 13.2,11.02 16.36,13.39 			' />
                    <polygon fill='#FFFFFF' points='20.06,24.82 22.78,24.82 21.42,26.73 			' />
                  </g>
                </g>
              </g>
            </svg>


            <span class='logo__text'>Minter<span class='logo__text-dark'>Cat</span></span>
          </a>

          <nav class='nav-top top-header__nav'>
            <svg version='1.1' class='nav-top__logo' xmlns='http://www.w3.org/2000/svg'
              xmlns:xlink='http://www.w3.org/1999/xlink' x='0px' y='0px' viewBox='0 0 42.36 42.23'
              enable-background='new 0 0 42.36 42.23' xml:space='preserve'>
              <g>
                <circle fill='#FFFFFF' cx='21.11' cy='21.11' r='21.11' class='nav-top__logo-circle' />
                <g>
                  <defs>
                    <circle id='SVGID_3_' cx='21.25' cy='21.11' r='21.11' />
                  </defs>
                  <clipPath id='SVGID_4_'>
                    <use xlink:href='#SVGID_3_' overflow='visible' />
                  </clipPath>
                  <g clip-path='url(#SVGID_4_)'>
                    <path fill='#1F2224' d='M12.25,8.4c0.29-1.1-9.79,34.57-5.13,44.21c3.54,7.33,24.52,9.66,28.48-0.1s-4.88-45-4.88-45l-5.8,5.03
                    l-6.43,0.37L12.25,8.4z' />
                    <line fill='#FFFFFF' stroke='#FFFFFF' stroke-width='0.5' stroke-miterlimit='10' x1='25.1' y1='24.23'
                      x2='30.83' y2='22.35' />
                    <line fill='#FFFFFF' stroke='#FFFFFF' stroke-width='0.5' stroke-miterlimit='10' x1='25.1' y1='26.23'
                      x2='31.66' y2='25.55' />
                    <line fill='#FFFFFF' stroke='#FFFFFF' stroke-width='0.5' stroke-miterlimit='10' x1='11.39'
                      y1='22.47' x2='17.6' y2='24.14' />
                    <line fill='#FFFFFF' stroke='#FFFFFF' stroke-width='0.5' stroke-miterlimit='10' x1='11.47'
                      y1='25.52' x2='17.71' y2='26.17' />
                    <polygon fill='#FFFFFF' points='26.64,13.25 29.51,10.68 29.91,13.73 			' />
                    <polygon fill='#FFFFFF' points='12.85,13.39 13.2,11.02 16.36,13.39 			' />
                    <polygon fill='#FFFFFF' points='20.06,24.82 22.78,24.82 21.42,26.73 			' />
                  </g>
                </g>
              </g>
            </svg>";
$m = 2; include('../menu.php');
            echo "$menu
			<ul class='social nav-top__social'>

              <li class='social__item'>
			<div class='social telegram'>
				<a href='https://t.me/MinterCat' target='_blank'><i class='fa fa-paper-plane fa-2x'></i></a>
			</div>
		</li>
          <li class='social__item'>
			<div class='social github'>
				<a href='https://github.com/MinterCat' target='_blank'><i class='fa fa-github fa-2x'></i></a>
			</div>
          </li>
          <li class='social__item'>
			<div class='social vk'>
				<a href='https://vk.com/MinterCat' target='_blank'><i class='fa fa-vk fa-2x'></i></a>
			</div>
          </li>
          <li class='social__item'>
            <div class='social twitter'>
				<a href='https://twitter.com/MinterCatGame' target='_blank'><i class='fa fa-twitter fa-2x'></i></a>
			</div>
          </li>
            </ul>

            <button class='nav-top__close'>
              <svg class='nav-top__close-icon'>
                <use xlink:href='#close-icon'></use>
              </svg>
            </button>

          </nav>

          <button class='btn-hamburger top-header__hamburger'>
            <span class='btn-hamburger__line'></span>
          </button>

        </div>
      </div>
    </header>

    <div class='profile-section'>
      <div class='container'>
        <div class='profile-section__inner'>

          <div class='avatar profile-section__avatar'>
             <img src='https://my.minter.network/api/v1/avatar/by/address/".$address."' class='avatar__img img-responsive'>
          </div>

		  <div style='position: center'>

            <div class='profile-info__item'>
              <div class='profile-info__item-title'>" . $Language->My_nickname . ":</div>
              <div class='profile-info__item-body'>
                <div class='profile-info__name'>$nick</div>
              </div>

            </div>
            <div class='profile-info__item'>
              <div class='profile-info__item-title'></div>
              <div class='profile-info__item-body'>
					<div class='tooltip'>
					</div>
              </div>
            </div>

          </div>

          <div class='wallet profile-section__wallet'>
            <div class='wallet__title'>Balance:</div>
            <div class='wallet__sum'>$balance</div>
			<img src='".$site."static/img/svg/logo.svg' class='wallet__avatar'>
			<div class='wallet__title'>$Language->Buying_a_new_kitten_costs 50 $coin</div>
				<form method='post'>
					<button class='button' id='buycat' name='buycat' type='submit'>$Language->Buy</button>
				</form>
          </div>
        </div>
      </div>
    </div>
</div>
";

if (isset($_POST['buycat']))
	{
		if ($balance > 50)
				{
					$img = rand(9990,9999); //egg

					$text = '{"type":0,"img":'.$img.'}';

					$kamil = $komsa/4; //25%
					$fond = $komsa - $kamil;
					
					$tx_array = array(
						array(
							'coin' => $coin,
							'to' => 'Mxf7c5a1a3f174a1c15f4671c1651d42377351b5b5',
							'value' => $kamil
						),
						array(
							'coin' => $coin,
							'to' => 'Mx836a597ef7e869058ecbcc124fae29cd3e2b4444',
							'value' => $fond
						),
					);
					
					$transaction = TransactionSend($api,$address,$privat_key,$chainId,$coin,$text,$tx_array);
					$code = $transaction->code;
					if ($code == 0) 
						{
							$hash = $transaction->hash;
							sleep(6);
							$block = $api->getTransaction($hash)->result->height;
							$db_cats->exec('CREATE TABLE IF NOT EXISTS "table" (
								"id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
								"stored_id" INTEGER,
								"addr" VARCHAR,
								"img" INTEGER,
								"price" INTEGER,
								"sale" INTEGER,
								"name" VARCHAR,
								"hash" VARCHAR
									)');
							$db_cats->exec('INSERT INTO "table" ("stored_id", "addr", "img", "price", "sale", "name", "hash")
								VALUES ("'.$block.'", "'.$address.'", "'.$img.'", "0", "0", "","'.$hash.'")');

							$a=9; $_SESSION['a'] = $a;
							header_lol($site.'profile');
														
						}
					else
						{
							$a=7; $_SESSION['a'] = $a;
							header_lol($site.'profile');
							
						}
				}
	}
$g = ob_get_contents();
ob_end_clean();
echo $g;