<?php
declare(strict_types=1);
require_once('../config/minterapi/vendor/autoload.php');
use Minter\MinterAPI;
use Minter\SDK\MinterWallet;
ob_start();
//========================================
$version = explode('public_html', $_SERVER['DOCUMENT_ROOT'])[1];
if ($version == 'testnet') {require_once($_SERVER['DOCUMENT_ROOT'] . 'config/config.php');}
else {require_once(explode('public_html', $_SERVER['DOCUMENT_ROOT'])[0] . 'config/config.php');}
require_once($_SERVER['DOCUMENT_ROOT'] . '/function.php');

$url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

$db_users = new Users();

//-----------------------
$base = $_SERVER['DOCUMENT_ROOT'] . '/explorer/session.txt';
include($_SERVER['DOCUMENT_ROOT'] . '/explorer/online.php');
//-----------------------
$session_language = $_SESSION['session_language'];
$cript_mnemonic = $_SESSION['cript_mnemonic'];

if ($cript_mnemonic != '') {
$decript_text = openssl_decrypt($cript_mnemonic, $crypt_method, $crypt_key, $crypt_options, $crypt_iv);
$decript = json_decode($decript_text,true);

$address = $decript['address'];

$check_language = User::Address($address)->language;
}

if ($check_language != '') {$Language = Language($check_language);}
elseif ($session_language != '') {$Language = Language($session_language);}
else {$Language = Language('English');}

//========================================
$api_node = new MinterAPI($api);
echo "
<!DOCTYPE html>
<html lang='en'>

<head>
<meta charset='utf-8'>
<meta name='viewport' content='width=device-width, initial-scale=1.0'>
<meta http-equiv='X-UA-Compatible' content='ie=edge'>

<title>MinterCat</title>
<link rel='shortcut icon' href='".$site."static/img/icons/Cats.webp'>
<link rel='stylesheet' href='".$site."static/css/swiper.min.css' media='all and (max-width: 480px)'>
<link rel='stylesheet' href='".$site."static/css/styles.min.css'>
<link rel='stylesheet' href='".$site."static/css/style_menu.css'>
<link rel='stylesheet' href='".$site."static/css/pagination.css'>
<link rel='stylesheet' href='".$site."static/css/social.css'>
<link rel='stylesheet' href='".$site."static/css/normalize.css'>
</head>

<body>

  <svg display='none'>
    <symbol id='illustration' viewBox='0 0 214.72 63.15'>
      <path d='M121.47,21.05h14.75c5.81,0,10.53-4.71,10.53-10.53S142.02,0,136.21,0H26.59
        c-5.81,0-10.53,4.71-10.53,10.53s4.71,10.53,10.53,10.53h48.46c5.81,0,10.53,4.71,10.53,10.53c0,5.81-4.71,10.53-10.53,10.53H58.56
        c-5.81,0-10.53,4.71-10.53,10.53c0,5.81,4.71,10.53,10.53,10.53h68.61c5.81,0,10.53-4.71,10.53-10.53
        c0-5.81-4.71-10.53-10.53-10.53h-5.71c-5.81,0-10.53-4.71-10.53-10.53C110.94,25.76,115.65,21.05,121.47,21.05z'>
      <path d='M214.72,10.93c0,6.04-4.89,10.93-10.93,10.93h-31.47c-6.04,0-10.93-4.89-10.93-10.93l0,0
        c0-6.04,4.89-10.93,10.93-10.93h31.47C209.82,0,214.72,4.89,214.72,10.93L214.72,10.93z'>
      <path d='M32.13,52.63c0,5.81-4.89,10.53-10.93,10.53H10.93C4.89,63.15,0,58.44,0,52.63l0,0
        C0,46.81,4.89,42.1,10.93,42.1H21.2C27.24,42.1,32.13,46.81,32.13,52.63L32.13,52.63z'>
    </symbol>

    <symbol id='close-icon' viewBox='0 0 22 23'>
      <path
        d='M1.362 22.345l-.724-.69 9.42-9.89L.646 2.354l.708-.708 9.393 9.394L20.637.655l.725.69-9.907 10.403 9.899 9.898-.708.708-9.881-9.882z' />
    </symbol>

  </svg>

  <div class='page'>
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
            </svg>
			"; $m = 1; include('menu.php'); echo "$menu
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

            <button class='nav-top__btn-play btn'>$Language->Play</button>

            <button class='nav-top__close'>
              <svg class='nav-top__close-icon'>
                <use xlink:href='#close-icon'></use>
              </svg>
            </button>

          </nav>

          <button class='top-header__btn-play'>$Language->Play</button>

          <button class='btn-hamburger top-header__hamburger'>
            <span class='btn-hamburger__line'></span>
          </button>

        </div>
      </div>
    </header>

    <div class='intro'>

      <div class='container'>
        <div class='intro__inner'>

          <div class='intro__content'>

            <div class='intro__logo-mobile'>
              <img src='".$site."static/img/svg/logo.svg' class='intro__logo-mobile-img'>
            </div>

            <div class='intro__text'>
              <h1 class='intro__heading'>
                Minter<span class='intro__heading-dark'>Cat</span>
              </h1>
              <p class='intro__descr'>$Language->Collect_crypto_kitty_on_the $Language->Minter_blockchain</p>
            </div>

            <button class='btn intro__btn'>$Language->Play</button>
          </div>

          <div class='intro__img-wrapper'>
            <div class='intro__img-inner' id='scene'>
              <div class='intro__img-layer-fake'></div>
              <div class='intro__img-layer intro__img-layer-1' data-depth='0.2'></div>
              <div class='intro__img-layer intro__img-layer-2' data-depth='0.4'></div>
              <div class='intro__img-layer intro__img-layer-3' data-depth='0.6'></div>
            </div>
          </div>

          <div class='intro__img-mobile'>

				<img src='".$site."static/img/@1x/card-cat.webp'>

          </div>

        </div>
      </div>

      <svg class='intro__illustration'>
        <use xlink:href='#illustration'></use>
      </svg>

    </div>
    <main class='main'>
      <div class='about main__about'>
        <div class='container about__container'>
          <span class='about__subtitle'>$Language->about_the_project</span>
          <h2 class='heading about__heading about__heading'>$Language->what_is_it</h2>

          <div class='swiper-container'>
            <div class='posts about__posts swiper-wrapper'>

              <div class='post posts__item swiper-slide'>

                <svg class='post__illustration'>
                  <use xlink:href='#illustration'></use>
                </svg>

                <div class='post__img-wrapper'>
                  <div class='post__img-inner'>
                    <picture>
			<source srcset='".$site."static/img/Cat1.webp' type='image/webp' class='post__img'>
			<img src='".$site."png.php?png=1' class='post__img'>
			</picture>
                  </div>
                </div>

                <p class='post__text'>$Language->The_Interact_project_is_a_crypto-kitty_on_the_Minter_blockchain $Language->Each_kitten_can_be_bought . </p>
              </div>

              <div class='post post--reverse posts__item swiper-slide'>

                <svg class='post__illustration post--reverse__illustration post__illustration--white'>
                  <use xlink:href='#illustration'></use>
                </svg>

                <div class='post__img-wrapper post--reverse__img-wrapper'>
                  <div class='post__img-inner'>
				  <picture>
			<source srcset='".$site."static/img/Cat902.webp' type='image/webp' class='post__img'>
			<img src='".$site."png.php?png=902' class='post__img'>
			</picture>
                  </div>
                </div>

                <p class='post__text'>$Language->Each_cat_has_its_own_set_of_genes $Language->When_crossing_the_genes_of_the</p>
              </div>

              <div class='post posts__item swiper-slide'>

                <svg class='post__illustration post__illustration--white'>
                  <use xlink:href='#illustration'></use>
                </svg>

                <div class='post__img-wrapper'>
                  <div class='post__img-inner'>
                    <picture>
			<source srcset='".$site."static/img/Cat22.webp' type='image/webp' class='post__img'>
			<img src='".$site."png.php?png=22' class='post__img'>
			</picture>
                  </div>
                </div>

                <p class='post__text'>$Language->Each_cat_has_its_own_approximate $Language->After_adding_new_seals</p>
              </div>
            </div>

          </div>

        </div>
      </div>
    </main>

    <footer class='footer page__footer'>
      <div class='container'>
        <div class='footer__logo'>Minter<span class='footer__logo-dark'>Cat</span></div>

        <ul class='social footer__social'>

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

		<span class='footer__copyright'>$Language->All_rights_are_registered</span><br>
		<span class='footer__copyright'>
		<a href='".$site."dev' target='_blank' class='nav-top__link'>API</a> | <a href='".$site."pco' target='_blank' class='nav-top__link'>PCO</a> | <a href='".$site."explorer' target='_blank' class='nav-top__link'>Explorer</a>
		</span>

      </div>
    </footer>
  </div>

  <div class='overlay overlay--white overlay--login'>
    <div class='modal-login'>
		<form class='modal-login__form' method='POST'>
			<div class='get-wallet-info'>
				<br>
				<textarea cols='36' rows='3' class='form-control' name='mnemonic' id='mnemonic' placeholder='Mnemonic phrase'></textarea>
				<br>
			</div>
			<br>
			<input id='Enter' name='Enter' type='submit' class='btn modal-login__btn' value='$Language->Enter'>
			<br>

			<input id='Register' name='Register' type='submit' class='btn modal-login__btn' value='$Language->Register'>
			<br>
			<a href='#' class='modal-login__link'>Alternative login to the site</a>
		</form>


      <div class='modal-login__cats'>
        <img src='".$site."static/img/@1x/card-cat.webp' class='modal-login__cat-img-1'>
        <img src='".$site."static/img/@1x/cat-yellow.webp' class='modal-login__cat-img-2'>
        <img src='".$site."static/img/@1x/cat-white.webp' class='modal-login__cat-img-3'>
      </div>

    </div>

    <button class='overlay__close'>
      <svg class='overlay__close-icon'>
        <use xlink:href='#close-icon'></use>
      </svg>
    </button>

  </div>

  <div class='overlay overlay--white overlay--reg'>
    <div class='modal-login'>
	      <form class='modal-login__form'>

        <div class='modal-login__form-group'>
          <label for='' class='modal-login__label'>$Language->Login :</label>
          <input id='login1' name='login1' type='login' class='modal-login__field-text' value=''  maxlength='15' required>
        </div>

        <div class='modal-login__form-group'>
          <label for='' class='modal-login__label'>$Language->Password :</label>
          <input id='password1' name='password1' type='password' class='modal-login__field-text' value=''  maxlength='15' required>
        </div>

        <input id='log' name='log' type='submit' class='btn modal-login__btn' value='$Language->Enter'>


        <a href='#' class='modal-login__link'>Back</a>

      </form>

      <div class='modal-login__cats'>
        <img src='".$site."static/img/@1x/card-cat.webp' class='modal-login__cat-img-1'>
        <img src='".$site."static/img/@1x/cat-yellow.webp' class='modal-login__cat-img-2'>
        <img src='".$site."static/img/@1x/cat-white.webp' class='modal-login__cat-img-3'>
      </div>

    </div>

    <button class='overlay__close'>
      <svg class='overlay__close-icon'>
        <use xlink:href='#close-icon'></use>
      </svg>
    </button>

  </div>

  <script src='".$site."static/js/parallax.min.js'></script>
  <script src='".$site."static/js/swiper.min.js'></script>
  <script src='".$site."static/js/_custom.js'></script>

  <script>
    var scene = document.getElementById('scene');
    var parallaxInstance = new Parallax(scene);

    var mySwiper = undefined;

    function initSwiper() {
      var screenWidth = window.innerWidth;
      if (screenWidth < 480 && mySwiper == undefined) {
        mySwiper = new Swiper('.swiper-container', {
          loop: true
        });
      } else if (screenWidth > 479 && mySwiper != undefined) {
        mySwiper.destroy();
        mySwiper = undefined;
        document.querySelector('.swiper-wrapper').removeAttribute('style');
        document.querySelector('.swiper-slide').removeAttribute('style');
      }
    }

    //Swiper plugin initialization
    initSwiper();

    window.addEventListener('resize', () => {
      initSwiper();
    });
  </script>

</body>

</html>
";

if (isset($_POST['Enter']))
	{
		$mnemonic = $_POST['mnemonic'];
		$seed = MinterWallet::mnemonicToSeed($mnemonic);
		$privateKey = MinterWallet::seedToPrivateKey($seed);
		$publicKey = MinterWallet::privateToPublic($privateKey);
		$address = MinterWallet::getAddressFromPublicKey($publicKey);

		$arr = array(
				'mnemonic' => $mnemonic,
				'address' => $address,
				'private_key' => $privateKey
			);

		$json = json_encode($arr, JSON_UNESCAPED_UNICODE);

		$cript_mnemonic = openssl_encrypt($json,$crypt_method,$crypt_key,$crypt_options,$crypt_iv);
		$_SESSION['cript_mnemonic'] = $cript_mnemonic;
		//------------------------------

		$data = $db_users->query('SELECT address FROM "table" WHERE address="'.$address.'"')->fetchArray(1);

		if ($data)
			{
				header_lol($site.'profile');
				
			}
		else
			{
				$db_users->exec('CREATE TABLE IF NOT EXISTS "table" (
					"id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
					"address" VARCHAR,
					"nick" VARCHAR,
					"language" VARCHAR
				)');
				$db_users->exec('INSERT INTO "table" ("address", "nick", "language")
					VALUES ("'.$address.'", "", "")');
				$data = $db_users->query('SELECT id FROM "table" WHERE address="'.$address.'"')->fetchArray(1);
				$id = $data['id'];
				$nick = "ID$id";
				$db_users->exec('UPDATE "table" SET nick = "'. $nick .'" WHERE address = "'. $address .'"');

				header_lol($site.'profile');
				
			}
	}
if (isset($_POST['Register']))
	{
		$wallet = MinterWallet::create();
		$mnemonic = $wallet['mnemonic'];
		$address = $wallet['address'];
		$privateKey = $wallet['private_key'];

		$arr = array(
				'mnemonic' => $mnemonic,
				'address' => $address,
				'private_key' => $privateKey
				);

		$json = json_encode($arr, JSON_UNESCAPED_UNICODE);

		$cript_mnemonic = openssl_encrypt($json,$crypt_method,$crypt_key,$crypt_options,$crypt_iv);
		$_SESSION['cript_mnemonic'] = $cript_mnemonic;
		//------------------------------
		$db_users->exec('CREATE TABLE IF NOT EXISTS "table" (
					"id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
					"address" VARCHAR,
					"nick" VARCHAR,
					"language" VARCHAR
				)');
		$db_users->exec('INSERT INTO "table" ("address", "nick", "language")
					VALUES ("'.$address.'", "", "")');

		$data = $db_users->query('SELECT id FROM "table" WHERE address="'.$address.'"')->fetchArray(1);
		$id = $data['id'];
		$nick = "ID$id";
		$db_users->exec('UPDATE "table" SET nick = "'. $nick .'" WHERE address = "'. $address .'"');
		//------------------------------
		$a=8; $_SESSION['a'] = $a;
		//------------------------------
		header_lol($site.'profile');
		
	}