<?php
//========================================
$titles = 'Refund';
$m = 3;
//-------------------------------
include('../../header2.php');
echo "<div class='cat_content' style='text-align: left; float: none;'>";
//-------------------------------
$node_key = 'Mp7373d6d5a4ec18d87d766e5b4c6d3a0c94b357c4460a9ed377bf5d09fcd77373';
$from = 'musk';
$name = 'Elon Musk node';
$comm = 3;

echo "<title>MinterCat | $name</title>";

$totalDelegatedBip = GetStatusPage()->totalDelegatedBip;
$numberOfBlocks = GetStatusPage()->numberOfBlocks;

class Reward extends SQLite3
{
    function __construct()
    {
        $this->open('../../../config/refund/musk.sqlite');
    }
}

$db = new Reward();
$data = $db->query('SELECT * FROM "'.$from.'"')->fetchArray(1);

$block_r = $data['numberOfBlocks'];
$block_reward = $block_r + 17280;

        echo "<h1>$name</h1><h4>$node_key</h4>
		REFUND has already been paid in block <a href='https://minterscan.net/block/$block_r' target='_blank'>$block_r</a> <br><br>
The current block $numberOfBlocks <br><br>
		The next REFUND will be paid after block $block_reward<br><br>";
		
        $blockReward = GetBlocks()->reward;

		$commision = 1 - ($comm/100);//commision(0..1) - комиссия валидатора

		$delegators = file_get_contents("https://minterscan.pro/validators/$node_key/delegators?coin=MINTERCAT");
		$delegatorspayload = json_decode($delegators,true);

		$count = count($delegatorspayload)-1;

		$will_get = JSON('https://api.mintercat.com/coin')->estimateCoinBuy;

			echo "
				-------------------------------
				<br>
				Block Reward: $blockReward BIP<br>
				Commision node: $comm% <br>
				Total Delegated Bip: $totalDelegatedBip BIP<br>
				1 BIP = $will_get MINTERCAT<br>
				-------------------------------
				<br>
				";

		$tx_reward = array();
$a = 0;
		for($i = 0; $i <= $count; $i++) 
			{
				$address = $delegatorspayload[$i]['address'];
				if (($address != 'Mx836a597ef7e869058ecbcc124fae29cd3e2b4444') and ($address != 'Mxaa9a68f11241eb18deff762eac316e2ccac22a03')) 
					{ $a+=1;
					    $mc_value = $delegatorspayload[$i]['value'];
						$bip_value = $delegatorspayload[$i]['bip_value'];
						$reward = $blockReward*17280*0.8*$bip_value*$commision/$totalDelegatedBip;
						$comm_node = ($blockReward*17280*0.8*$bip_value*1/$totalDelegatedBip)-$reward;
						$value = $will_get*$comm_node;
						
						$json_profile = file_get_contents("https://minterscan.pro/profiles/$address");
						$profile = json_decode($json_profile,true);
						$title = $profile['title'];
						
						if ($title == '') {$title = $address;}
						
						echo "<br>$a)
								Address:  <a href='https://minterscan.net/address/$address' target='_blank'>$title</a><br>
								Delegated: $mc_value MINTERCAT<br>
								Bip value: $bip_value BIP<br>
								Reward: $reward BIP<br>
								Commision node: $comm_node BIP<br>
								Refund: $value MINTERCAT
								<br><br>
						";
					}
			}
//-------------------------------
echo '</div>';
include('../../footer.php');