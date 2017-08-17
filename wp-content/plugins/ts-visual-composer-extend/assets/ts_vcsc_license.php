<?php
	global $VISUAL_COMPOSER_EXTENSIONS;
	$ts_vcsc_extend_settings_licenseKeyed 									= '';
	$ts_vcsc_extend_settings_licenseRemove									= 'false';

	// Check License Key with Envato API
	// ---------------------------------
	if (!function_exists('TS_VCSC_checkEnvatoAPI')){
		function TS_VCSC_checkEnvatoAPI() {
			global $VISUAL_COMPOSER_EXTENSIONS;
			if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginIsMultiSiteActive == "true") {
				if (strlen(get_site_option('ts_vcsc_extend_settings_license')) != 0) {
					$envato_code 													= get_site_option('ts_vcsc_extend_settings_license');
				} else {
					$envato_code 													= "";
				}
				$ts_vcsc_extend_settings_licenseKeyed 								= get_site_option('ts_vcsc_extend_settings_licenseKeyed',			'emptydelimiterfix');
			} else {
				if (strlen(get_option('ts_vcsc_extend_settings_license')) != 0) {
					$envato_code 													= get_option('ts_vcsc_extend_settings_license');
				} else {
					$envato_code 													= "";
				}
				$ts_vcsc_extend_settings_licenseKeyed 								= get_option('ts_vcsc_extend_settings_licenseKeyed',				'emptydelimiterfix');
			}		
			$envato_success 					= false;
			$envato_result 						= false;
			$envato_response					= "";
			$envato_error						= "";
			if (!in_array(base64_encode($envato_code), $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Avoid_Duplications)) {			
				if ((function_exists('curl_init')) && (strlen($envato_code) != 0)) {
					$ch                         = curl_init();
					$timeout                    = 60;                
					$headers = array(
						'Authorization: Bearer '. $envato_code
					);                
					curl_setopt($ch, CURLOPT_URL,               $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_External_URL . $envato_code . '&protocol=' . TS_VCSC_SiteProtocol() . '&clienturl=' . preg_replace('#^https?://#', '', site_url()));
					curl_setopt($ch, CURLOPT_HTTPHEADER,        $headers);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER,    true);
					curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,    $timeout);
					curl_setopt($ch, CURLOPT_MAXREDIRS,         3);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 	false);
					curl_setopt($ch, CURLOPT_USERAGENT,         'Composium - Visual Composer Extensions (7190695) by Tekanewa Scripts');
					$envato_response			= curl_exec($ch);
					if (!curl_errno($ch)) {
						$envato_success			= true;
					} else {
						$envato_error			= curl_errno($ch);
					}
					curl_close($ch);
				}
			}
			if ((strlen($envato_response) != 0 && ($envato_success == true))) {
				if ((strlen($envato_code) == 0) || (strpos($envato_response, $envato_code) === FALSE)) {
					if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginIsMultiSiteActive == "true") {
						update_site_option('ts_vcsc_extend_settings_licenseValid', 	0);
						update_site_option('ts_vcsc_extend_settings_licenseKeyed', 	'emptydelimiterfix');
						update_site_option('ts_vcsc_extend_settings_licenseInfo', 	((strlen($envato_code) != 0) ? $envato_response : ''));
					} else {
						update_option('ts_vcsc_extend_settings_licenseValid', 		0);
						update_option('ts_vcsc_extend_settings_licenseKeyed', 		'emptydelimiterfix');
						update_option('ts_vcsc_extend_settings_licenseInfo', 		((strlen($envato_code) != 0) ? $envato_response : ''));
					}
					$LicenseCheckStatus 		= '<div class="clearFixMe" style="color: red; font-weight: bold; padding-bottom: 10px;">License Check has been initiated but was unsuccessful!</div>';
					$LicenseCheckSuccess 		= 0;
				} else if ((strlen($envato_code) != 0) && (strpos($envato_response, $envato_code) != FALSE)) {
					if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginIsMultiSiteActive == "true") {
						update_site_option('ts_vcsc_extend_settings_licenseValid', 	1);
						update_site_option('ts_vcsc_extend_settings_licenseKeyed', 	$envato_code);
						update_site_option('ts_vcsc_extend_settings_licenseInfo', 	str_replace("Link_To_Envato_Image", TS_VCSC_GetResourceURL('images/envato/envato_logo.png'), $envato_response));
					} else {
						update_option('ts_vcsc_extend_settings_licenseValid', 		1);
						update_option('ts_vcsc_extend_settings_licenseKeyed', 		$envato_code);
						update_option('ts_vcsc_extend_settings_licenseInfo', 		str_replace("Link_To_Envato_Image", TS_VCSC_GetResourceURL('images/envato/envato_logo.png'), $envato_response));
					}
					$LicenseCheckStatus 		= '<div class="clearFixMe" style="color: green; font-weight: bold; padding-bottom: 10px;">License Check has been succesfully completed!</div>';
					$LicenseCheckSuccess 		= 1;
				} else {
					if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginIsMultiSiteActive == "true") {
						update_site_option('ts_vcsc_extend_settings_licenseValid', 	0);
						update_site_option('ts_vcsc_extend_settings_licenseKeyed', 	'emptydelimiterfix');
						update_site_option('ts_vcsc_extend_settings_licenseInfo', 	((strlen($envato_code) != 0) ? $envato_response : ''));
					} else {
						update_option('ts_vcsc_extend_settings_licenseValid', 		0);
						update_option('ts_vcsc_extend_settings_licenseKeyed', 		'emptydelimiterfix');
						update_option('ts_vcsc_extend_settings_licenseInfo', 		((strlen($envato_code) != 0) ? $envato_response : ''));
					}
					$LicenseCheckStatus 		= '<div class="clearFixMe" style="color: red; font-weight: bold; padding-bottom: 10px;">License Check has been initiated but was unsuccessful!</div>';
					$LicenseCheckSuccess 		= 0;
				}
			} else {
				if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginIsMultiSiteActive == "true") {
					update_site_option('ts_vcsc_extend_settings_licenseValid', 		0);
					update_site_option('ts_vcsc_extend_settings_licenseKeyed', 		'emptydelimiterfix');
					update_site_option('ts_vcsc_extend_settings_licenseInfo', 		'');
				} else {
					update_option('ts_vcsc_extend_settings_licenseValid', 			0);
					update_option('ts_vcsc_extend_settings_licenseKeyed', 			'emptydelimiterfix');
					update_option('ts_vcsc_extend_settings_licenseInfo', 			'');
				}
				if (in_array(base64_encode($envato_code), $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Avoid_Duplications)) {
					$LicenseCheckStatus 		= '<div class="clearFixMe" style="color: red; font-weight: bold; padding-bottom: 10px;">The License Key has been revoked by Envato due to a full refund of the purchase price!</div>';
				} else {
					$LicenseCheckStatus 		= '<div class="clearFixMe" style="color: red; font-weight: bold; padding-bottom: 10px;">License Check could not be initiated - Missing License Key!</div>';
				}
				$LicenseCheckSuccess = 0;
			}
		}
	}
	
	// Get Item Information from Envato
	// --------------------------------
	if (!function_exists('TS_VCSC_SiteProtocol')){
		function TS_VCSC_SiteProtocol() {
			if (stripos($_SERVER['SERVER_PROTOCOL'], 'https') === true) {
				return 'https';
			} else if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) {
				return 'https';
			} else {
				return 'http';
			}
		}
	}
	if (!function_exists('TS_VCSC_ShowInformation')){
		function TS_VCSC_ShowInformation($item_id, $item_vc = true) {
			global $VISUAL_COMPOSER_EXTENSIONS;			
			if (isset($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Envato_Globals['migrate'])) {
				$item_migrate 						= $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Envato_Globals['migrate'];
			} else if (isset($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Envato_Defaults['migrate'])) {
				$item_migrate 						= $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Envato_Defaults['migrate'];
			} else {
				$item_migrate						= false;
			}
			if (($item_vc == true) || ($item_id == "")) {
				$item_id 							= $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_API_ItemID;
			}
			$api_storage							= get_option("ts_vcsc_extend_settings_envato", array());			
			$api_path 								= "https://api.envato.com/v2/market/catalog/item?id=" . $item_id;
			if (isset($api_storage['last'])) {
				$api_last							= $api_storage['last'];
			} else {
				$api_last							= 0;
			}
			$api_current							= time();
			if (isset($api_storage['data'])) {
				$api_data							= $api_storage['data'];
			} else {
				$api_data							= "";
			}
			$api_error 								= "";
			$api_success 							= false;
			if (($api_data == "") || (($api_last + 3600) < $api_current) || ($item_migrate == false)) {
				if ((function_exists('curl_init')) && (strlen($item_id) != 0)) {
					$ch                         	= curl_init();
					$timeout                    	= 60;                
					$headers = array(
						'Authorization: Bearer '. $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_API_Token,
					);                
					curl_setopt($ch, CURLOPT_URL,               $api_path);
					curl_setopt($ch, CURLOPT_HTTPHEADER,        $headers);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER,    true);
					curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,    $timeout);
					curl_setopt($ch, CURLOPT_MAXREDIRS,         3);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 	false);
					curl_setopt($ch, CURLOPT_USERAGENT,         'Composium - Visual Composer Extensions (7190695) by Tekanewa Scripts');
					$response						= curl_exec($ch);
					if (!curl_errno($ch)) {
						$item 						= true;
						$api_success				= true;
					} else {
						$item 						= false;
						$api_error					= curl_error($ch);
					}
					curl_close($ch);
				} else {
					$item 							= false;
				}
				if (($item == true) && ($api_success == true)) {
					/* Transform the JSON string into a PHP array */
					$item 							= json_decode($response, true);
					/* Check for incorrect data */
					if (!is_array($item)) {
						$item						= false;
					}
				}
				if (($item == false) && ($api_data != "")) {
					$item 							= $api_data;
				}
			} else {
				$item								= $api_data;
			}
			if ($item === false) {
				$TS_VCSC_Envato_Item_HTML 		= '<p style="text-align: justify;">' . __( "Oops... Something went wrong. Could not retrieve item information from Envato.", "ts_visual_composer_extend" ) . '</p>';
				echo $TS_VCSC_Envato_Item_HTML;
			} else {
				// Parse Item Data
				$TS_VCSC_Envato_Item_Data		= array();
				$TS_VCSC_Envato_Item_Name     	= (isset($item["name"]) 			? $item["name"] 			: "N/A");
				$TS_VCSC_Envato_Item_User		= (isset($item["author_username"]) 	? $item["author_username"] 	: "N/A");
				$TS_VCSC_Envato_Item_Rating		= (isset($item["rating"]["rating"]) ? $item["rating"]["rating"] : "N/A");
				$TS_VCSC_Envato_Item_Votes		= (isset($item["rating"]["count"]) 	? $item["rating"]["count"] 	: "N/A");
				$TS_VCSC_Envato_Item_Sales		= (isset($item["number_of_sales"]) 	? $item["number_of_sales"] 	: "N/A");
				$TS_VCSC_Envato_Item_Price		= (isset($item["price_cents"]) 		? $item["price_cents"] 		: "N/A");
				$TS_VCSC_Envato_Item_Thumb		= (isset($item["thumbnail_url"]) 	? $item["thumbnail_url"] 	: "N/A");
				$TS_VCSC_Envato_Item_Link		= (isset($item["url"]) 				? $item["url"] 				: "N/A");
				$TS_VCSC_Envato_Item_Release	= (isset($item["published_at"]) 	? $item["published_at"] 	: "N/A");
				$TS_VCSC_Envato_Item_Update		= (isset($item["updated_at"]) 		? $item["updated_at"] 		: "N/A");
				$TS_VCSC_Envato_Item_Check		= time();
				// Populate Data Array
				$TS_VCSC_Envato_Item_Data["name"] 					= $TS_VCSC_Envato_Item_Name;
				$TS_VCSC_Envato_Item_Data["author_username"]		= $TS_VCSC_Envato_Item_User;
				$TS_VCSC_Envato_Item_Data["rating"]["rating"]		= $TS_VCSC_Envato_Item_Rating;
				$TS_VCSC_Envato_Item_Data["rating"]["count"]		= $TS_VCSC_Envato_Item_Votes;
				$TS_VCSC_Envato_Item_Data["number_of_sales"]		= $TS_VCSC_Envato_Item_Sales;
				$TS_VCSC_Envato_Item_Data["price_cents"]			= $TS_VCSC_Envato_Item_Price;
				$TS_VCSC_Envato_Item_Data["thumbnail_url"]			= $TS_VCSC_Envato_Item_Thumb;
				$TS_VCSC_Envato_Item_Data["url"]					= $TS_VCSC_Envato_Item_Link;
				$TS_VCSC_Envato_Item_Data["published_at"]			= $TS_VCSC_Envato_Item_Release;
				$TS_VCSC_Envato_Item_Data["updated_at"]				= $TS_VCSC_Envato_Item_Update;
				// Create HTML Output
				$TS_VCSC_Envato_Item_HTML 	= '';
				$TS_VCSC_Envato_Item_HTML .= '
					<div class="ts-envato-item-info-wrapper">
						<div class="ts-envato-item-info-title">' . $TS_VCSC_Envato_Item_Name . '</div>
						<div class="ts-envato-item-info-main">
							<div class="ts-envato-item-info-top">
								<div class="ts-envato-item-info-rating"><span class="ts-envato-item-info-desc">' . __( "Rating", "ts_visual_composer_extend" ) . '</span>' . TS_VCSC_GetEnvatoStars(round($TS_VCSC_Envato_Item_Rating)) . '</div>
							</div>
							<div class="ts-envato-item-info-middle">
								<div class="ts-envato-item-info-sales">
									<span class="ts-envato-item-info-imgsales"></span>
									<div class="ts-envato-item-info-text">
										<span class="ts-envato-item-info-num">' . number_format(floatval($TS_VCSC_Envato_Item_Sales), 0) . '</span>
										<span class="ts-envato-item-info-desc">' . __( "Sales", "ts_visual_composer_extend" ) . '</span>
									</div>
								</div>
								<div class="ts-envato-item-info-thumb">
									<img src="' . $TS_VCSC_Envato_Item_Thumb . '" alt="' . $TS_VCSC_Envato_Item_Name . '" width="80" height="80"/>
								</div>
								<div class="ts-envato-item-info-price">
									<span class="ts-envato-item-info-imgprice"></span>
									<div class="ts-envato-item-info-text">
										<span class="ts-envato-item-info-num"><span>$</span>' . round($TS_VCSC_Envato_Item_Price / 100) . '</span>
										<span class="ts-envato-item-info-desc">' . __( "Only", "ts_visual_composer_extend" ) . '</span>
									</div>
								</div>
							</div>
							<div class="ts-envato-item-info-bottom">
								<div class="ts-advanced-link-button-wrapper ts-advanced-link-tooltip-holder" style="display: inline-block;">
									<span class="ts-advanced-link-tooltip-content">' . __( "Click here to purchase a license for the plugin.", "ts_visual_composer_extend" ) . '</span>
									<a href="' . $TS_VCSC_Envato_Item_Link . '" target="_blank" class="ts-advanced-link-button-main ts-advanced-link-button-orange ts-advanced-link-button-purchase">' . __( "Purchase", "ts_visual_composer_extend" ) . '</a>
								</div>
							</div>
						</div>
					</div>';
				if ($item_vc == true) {					
					$VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Envato_Globals	= array(
						'last'											=> time(),
						'data'                                          => $TS_VCSC_Envato_Item_Data,
						'name'                                          => $TS_VCSC_Envato_Item_Name,
						'info'                                          => $TS_VCSC_Envato_Item_HTML,
						'link'                                          => $TS_VCSC_Envato_Item_Link,
						'price'                                         => $TS_VCSC_Envato_Item_Price,
						'sales'                                         => $TS_VCSC_Envato_Item_Sales,
						'rating'                                        => TS_VCSC_GetEnvatoStars($TS_VCSC_Envato_Item_Rating),
						'votes'                                         => $TS_VCSC_Envato_Item_Votes,
						'check'                                         => $TS_VCSC_Envato_Item_Check,
						'migrate'										=> true,
					);
					update_option("ts_vcsc_extend_settings_envato", $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Envato_Globals);
				} else {
					echo $TS_VCSC_Envato_Item_HTML;
				}
			}
		}
	}
	if (!function_exists('TS_VCSC_GetEnvatoStars')){
		function TS_VCSC_GetEnvatoStars($rating) {
			if ((int) $rating == 0) {
				return '<div class="ts-envato-item-info-norating">' . __('Not Rated Yet.', 'ts_visual_composer_extend') . '</div>';
			}
			$return = '<ul class="ts-envato-item-info-stars">';
			$i=1;
			while ((--$rating) >= 0) {
				$return .= '<li class="ts-envato-item-info-fullstar"></li>';
				$i++;
			}
			if ($rating == -0.5) {
				$return .= '<li class="ts-envato-item-info-fullstar"></li>';
				$i++;
			}
			while ($i <= 5) {
				$return .= '<li class="ts-envato-item-info-emptystar"></li>';
				$i++;
			}
			$return .= '</ul>';
			return $return;
		}
	}
	
	// Save / Load Parameters
	// ----------------------
	if (isset($_POST['License'])) {		
		echo '<div id="ts_vcsc_extend_settings_save" style="position: relative; margin: 20px auto 20px auto; width: 128px; height: 128px;">';
			echo TS_VCSC_CreatePreloaderCSS("ts-settings-panel-loader", "", 4, "false");
		echo '</div>';		
		$ts_vcsc_extend_settings_license 									= trim ($_POST['ts_vcsc_extend_settings_license']);
		if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginIsMultiSiteActive == "true") {
			$ts_vcsc_extend_settings_licenseKeyed 							= get_site_option('ts_vcsc_extend_settings_licenseKeyed',		'emptydelimiterfix');
			$ts_vcsc_extend_settings_licenseInfo 							= get_site_option('ts_vcsc_extend_settings_licenseInfo',		'');
			update_site_option('ts_vcsc_extend_settings_license', 			$ts_vcsc_extend_settings_license);
			update_site_option('ts_vcsc_extend_settings_licenseUpdate', 	1);
		} else {
			$ts_vcsc_extend_settings_licenseKeyed 							= get_option('ts_vcsc_extend_settings_licenseKeyed',			'emptydelimiterfix');
			$ts_vcsc_extend_settings_licenseInfo 							= get_option('ts_vcsc_extend_settings_licenseInfo',				'');
			update_option('ts_vcsc_extend_settings_license', 				$ts_vcsc_extend_settings_license);
			update_option('ts_vcsc_extend_settings_licenseUpdate', 			1);
		}
		echo '<script> window.location="' . $_SERVER['REQUEST_URI'] . '"; </script> ';
		//Header('Location: '.$_SERVER['REQUEST_URI']);
		Exit();
	} else if (isset($_POST['Unlicense'])) {
		if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginIsMultiSiteActive == "true") {
			update_site_option('ts_vcsc_extend_settings_license', 			'');
			update_site_option('ts_vcsc_extend_settings_licenseKeyed', 		'unlicenseinprogress');
			update_site_option('ts_vcsc_extend_settings_licenseUpdate', 	1);
		} else {
			update_option('ts_vcsc_extend_settings_license', 				'');
			update_option('ts_vcsc_extend_settings_licenseKeyed', 			'unlicenseinprogress');
			update_option('ts_vcsc_extend_settings_licenseUpdate', 			1);
		}
		echo '<script> window.location="' . $_SERVER['REQUEST_URI'] . '"; </script> ';
		//Header('Location: '.$_SERVER['REQUEST_URI']);
		Exit();
	} else {
		TS_VCSC_ShowInformation('7190695');
		if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginIsMultiSiteActive == "true") {
			$ts_vcsc_extend_settings_license 								= get_site_option('ts_vcsc_extend_settings_license',			'');
			$ts_vcsc_extend_settings_licenseKeyed 							= get_site_option('ts_vcsc_extend_settings_licenseKeyed',		'emptydelimiterfix');
			$ts_vcsc_extend_settings_licenseInfo 							= get_site_option('ts_vcsc_extend_settings_licenseInfo',		'');
		} else {
			$ts_vcsc_extend_settings_license 								= get_option('ts_vcsc_extend_settings_license',					'');
			$ts_vcsc_extend_settings_licenseKeyed 							= get_option('ts_vcsc_extend_settings_licenseKeyed',			'emptydelimiterfix');
			$ts_vcsc_extend_settings_licenseInfo 							= get_option('ts_vcsc_extend_settings_licenseInfo',				'');
		}
		
		if ($ts_vcsc_extend_settings_licenseKeyed == 'unlicenseinprogress') {
			if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginIsMultiSiteActive == "true") {
				update_site_option('ts_vcsc_extend_settings_licenseKeyed', 'emptydelimiterfix');
			} else {
				update_option('ts_vcsc_extend_settings_licenseKeyed', 'emptydelimiterfix');
			}
			$ts_vcsc_extend_settings_licenseRemove 					= 'true';
		}
		
		if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginIsMultiSiteActive == "true") {
			if (get_site_option('ts_vcsc_extend_settings_licenseUpdate') == 1) {
				TS_VCSC_checkEnvatoAPI();
				echo "\n";
				echo "<script type='text/javascript'>" . "\n";
				echo "SettingsLicenseUpdate = true;" . "\n";
					if (get_site_option('ts_vcsc_extend_settings_licenseValid') == 1) {
						echo 'VC_Extension_Demo = false;' . "\n";
					} else {
						echo 'VC_Extension_Demo = true;' . "\n";
					}
					if (strlen(get_site_option('ts_vcsc_extend_settings_license')) != 0) {
						echo "SettingsLicenseKey = true;" . "\n";
					} else {
						echo "SettingsLicenseKey = false;" . "\n";
					}
				if ($ts_vcsc_extend_settings_licenseRemove == 'true') {
					echo "SettingsUnLicensing = true;" . "\n";
				} else {
					echo "SettingsUnLicensing = false;" . "\n";
				}
				echo "</script>" . "\n";
			} else {
				echo "\n";
				echo "<script type='text/javascript'>" . "\n";
				echo "SettingsLicenseUpdate = false;" . "\n";
					if (get_site_option('ts_vcsc_extend_settings_licenseValid') == 1) {
						echo 'VC_Extension_Demo = false;' . "\n";
					} else {
						echo 'VC_Extension_Demo = true;' . "\n";
					}
					if (strlen(get_site_option('ts_vcsc_extend_settings_license')) != 0) {
						echo "SettingsLicenseKey = true;" . "\n";
					} else {
						echo "SettingsLicenseKey = false;" . "\n";
					}
				if ($ts_vcsc_extend_settings_licenseRemove == 'true') {
					echo "SettingsUnLicensing = true;" . "\n";
				} else {
					echo "SettingsUnLicensing = false;" . "\n";
				}
				echo "</script>" . "\n";
			}
		} else {
			if (get_option('ts_vcsc_extend_settings_licenseUpdate') == 1) {
				TS_VCSC_checkEnvatoAPI();
				echo "\n";
				echo "<script type='text/javascript'>" . "\n";
				echo "SettingsLicenseUpdate = true;" . "\n";
					if (get_option('ts_vcsc_extend_settings_licenseValid') == 1) {
						echo 'VC_Extension_Demo = false;' . "\n";
					} else {
						echo 'VC_Extension_Demo = true;' . "\n";
					}
					if (strlen(get_option('ts_vcsc_extend_settings_license')) != 0) {
						echo "SettingsLicenseKey = true;" . "\n";
					} else {
						echo "SettingsLicenseKey = false;" . "\n";
					}
				if ($ts_vcsc_extend_settings_licenseRemove == 'true') {
					echo "SettingsUnLicensing = true;" . "\n";
				} else {
					echo "SettingsUnLicensing = false;" . "\n";
				}
				echo "</script>" . "\n";
			} else {
				echo "\n";
				echo "<script type='text/javascript'>" . "\n";
				echo "SettingsLicenseUpdate = false;" . "\n";
					if (get_option('ts_vcsc_extend_settings_licenseValid') == 1) {
						echo 'VC_Extension_Demo = false;' . "\n";
					} else {
						echo 'VC_Extension_Demo = true;' . "\n";
					}
					if (strlen(get_option('ts_vcsc_extend_settings_license')) != 0) {
						echo "SettingsLicenseKey = true;" . "\n";
					} else {
						echo "SettingsLicenseKey = false;" . "\n";
					}
				if ($ts_vcsc_extend_settings_licenseRemove == 'true') {
					echo "SettingsUnLicensing = true;" . "\n";
				} else {
					echo "SettingsUnLicensing = false;" . "\n";
				}
				echo "</script>" . "\n";
			}
		}
		if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginIsMultiSiteActive == "true") {
			update_site_option('ts_vcsc_extend_settings_licenseUpdate', 	0);
		} else {
			update_option('ts_vcsc_extend_settings_licenseUpdate', 			0);
		}		
		$LicenseCheckStatus = "";
	}
	echo '<div class="ts-vcsc-settings-group-header">';
		echo '<div class="display_header">';
			echo '<h2><span class="dashicons dashicons-admin-network"></span>Composium - Visual Composer Extensions v' . TS_VCSC_GetPluginVersion() . ' ... License Information</h2>';
		echo '</div>';
		echo '<div class="clear"></div>';
	echo '</div>';
?>
<form id="ts-vcsc-license-check-wrap" class="ts-vcsc-license-check-wrap" name="oscimp_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
	<div class="ts-vcsc-extend-license-strings" style="display: none;">
		<div id="ts-vcsc-extend-license-confirm"><?php echo __('Your Envato license key has been confirmed! Thank you for your purchase!', 'ts_visual_composer_extend'); ?></div>
		<div id="ts-vcsc-extend-license-unlicense"><?php echo __('"Composium - Visual Composer Extensions" has been unlicensed for this site and the auto-update feature has been removed accordingly!', 'ts_visual_composer_extend'); ?></div>
		<div id="ts-vcsc-extend-license-invalid"><?php echo __('Problem: Your Envato license key could not be confirmed!', 'ts_visual_composer_extend'); ?></div>
		<div id="ts-vcsc-extend-license-missing"><?php echo __('Problem: You did not provide a license key to check!', 'ts_visual_composer_extend'); ?></div>
		<div id="ts-vcsc-extend-license-close"><?php echo __('Close', 'ts_visual_composer_extend'); ?></div>
	</div>
	<div class="ts-vcsc-section-main">
		<div class="ts-vcsc-section-title ts-vcsc-section-show"><i class="dashicons-info"></i>License Information</div>
		<div class="ts-vcsc-section-content">
			<?php
				if (current_user_can('manage_options')) {
					echo '<div class="ts-advanced-link-button-wrapper ts-advanced-link-tooltip-holder" style="margin: 10px 0;">
						<span class="ts-advanced-link-tooltip-content">' . __("Click here to return to the plugins settings page.", "ts_visual_composer_extend") . '</span>
						<a href="' . $VISUAL_COMPOSER_EXTENSIONS->settingsLink . '" target="_parent" class="ts-advanced-link-button-main ts-advanced-link-button-grey ts-advanced-link-button-settings">'. __("Back to Settings", "ts_visual_composer_extend") . '</a>
					</div>';
				}
				if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginIsMultiSiteActive == "true") {
					if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginValid == "false") {
						echo '<div class="ts-vcsc-info-field ts-vcsc-warning" style="margin-top: 10px; font-size: 13px; text-align: justify;">Please enter your license key in order to activate the auto-update routine of the plugin!</div>';
					}
				} else {
					if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginValid == "false") {
						echo '<div class="ts-vcsc-info-field ts-vcsc-warning" style="margin-top: 10px; font-size: 13px; text-align: justify;">Please enter your license key in order to activate the auto-update routine of the plugin!</div>';
					}
				}
			?>			
			<div class="ts-vcsc-notice-field ts-vcsc-warning" style="margin-top: 10px; font-size: 13px; text-align: justify;">
				In order to use this plugin, you MUST have the Visual Composer Plugin installed; either as a normal plugin or as part of your theme. If Visual Composer is part of your theme, please ensure that it has not been modified;
				some theme developers heavily modify Visual Composer in order to allow for certain theme functions. Unfortunately, some of these modification prevent this extension pack from working correctly.
			</div>			
			<?php
				if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginIsMultiSiteActive == "true") {
					$envato_code = get_site_option('ts_vcsc_extend_settings_license', '');
					echo '<div class="ts-vcsc-info-field ts-vcsc-critical" style="margin-top: 10px; font-size: 13px; text-align: justify; font-weight: bold;">';
						echo 'This plugin has been activated network-wide in a WordPress MultiSite environment. Please consider purchasing additional licenses for the plugin as Envato license rules restrict usage to one domain only! Thank you!';
					echo '</div>';
				} else {
					$envato_code = get_option('ts_vcsc_extend_settings_license', '');
				}
				if (in_array(base64_encode($envato_code), $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Avoid_Duplications)) {
					echo '<div class="ts-vcsc-info-field ts-vcsc-critical" style="margin-top: 10px; font-size: 13px; text-align: justify; font-weight: bold;">';
						echo 'The license key you are attempting to use has been revoked by Envato due to the fact that the buyer received a full refund of the purchase price. Continued usage of the product is illegal!';
					echo '</div>';
				}
			?>
		</div>		
	</div>
	<?php
		if (!function_exists('curl_init')) {
			echo '<div class="ts-vcsc-section-main">';
				echo '<div class="ts-vcsc-section-title ts-vcsc-section-show"><i class="dashicons-dismiss" style="color: red;"></i>No cURL Support!</div>';
				echo '<div class="ts-vcsc-section-content">';
					echo '<div class="ts-vcsc-info-field ts-vcsc-critical" style="margin-top: 10px; font-size: 13px; text-align: justify;">';
						echo 'In order to check your license key and to retrieve any information from Envato, this plugin requires cURL to be enabled on and support by your server, which does not seem to be the case. Without
						cURL support, you will not be able to confirm your license key. Please check your server settings and/or contact your hosting service in order to enable and use cURL.';
					echo '</div>';
				echo '</div>';
			echo '</div>';
		}
	?>
	<div class="ts-vcsc-section-main">
		<div class="ts-vcsc-section-title ts-vcsc-section-hide"><i class="dashicons-search"></i><?php echo __("How To Find Your License Key", "ts_visual_composer_extend"); ?></div>
		<div class="ts-vcsc-section-content slideFade" style="display: none;">
			<iframe class="wistia_embed" src="//fast.wistia.net/embed/iframe/gqsrs2assi" name="wistia_embed" width="640" height="400" frameborder="0" scrolling="no" allowfullscreen="allowfullscreen" mozallowfullscreen="mozallowfullscreen" webkitallowfullscreen="webkitallowfullscreen" oallowfullscreen="oallowfullscreen" msallowfullscreen="msallowfullscreen"></iframe>
		</div>
	</div>
	<div class="ts-vcsc-extend-license-content" style="min-height: 100px; width: 100%; margin-top: 20px;">
		<table style="border: 1px solid #ededed; min-height: 100px; width: 100%;">
			<tr>
				<td style="width: 250px; padding: 0px 20px 0px 20px; border-right: 1px solid #ededed;">
					<?php
						$TS_TablesVC_Envato_Item_HTML = get_option('ts_vcsc_extend_settings_envato', array());
						if (isset($TS_TablesVC_Envato_Item_HTML['info'])) {
							echo $TS_TablesVC_Envato_Item_HTML['info'];
						}
					?>
				</td>
				<td>
					<div>
						<h4 style="margin-top: 20px;"><span style="margin-left: 10px;">Envato Purchase License Key:</span></h4>
						<p style="margin-top: 5px; margin-left: 10px; margin-bottom: 15px;">Please enter your Envato Purchase License Key here:</p>
						<?php echo $LicenseCheckStatus; ?>
						<label style="margin-left: 10px;" class="Uniform" for="ts_vcsc_extend_settings_license">Envato License Key:</label>
						<input class="<?php
							if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginIsMultiSiteActive == "true") {
								echo ((get_site_option('ts_vcsc_extend_settings_licenseValid') == 0) ? "Required" : "");
							} else {
								echo ((get_option('ts_vcsc_extend_settings_licenseValid') == 0) ? "Required" : "");
							}
						?>" type="input" style="width: 20%; height: 30px; margin: 0 10px;" id="ts_vcsc_extend_settings_license" name="ts_vcsc_extend_settings_license" value="<?php echo $ts_vcsc_extend_settings_license; ?>" size="100">
						<?php
							if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginIsMultiSiteActive == "true") {
								if (strlen(get_site_option('ts_vcsc_extend_settings_license')) != 0) {
									echo get_site_option('ts_vcsc_extend_settings_licenseInfo');
									if (get_site_option('ts_vcsc_extend_settings_licenseValid') == 0) {
										echo '<div class="ts_vcsc_extend_messi_link clearFixMe" data-title="Retrieve your Envato License Code" data-source="' . TS_VCSC_GetResourceURL('images/envato/envato_find_license_key.png') .'" style="cursor: pointer; margin-left: 10px; margin-top: 10px;">';
											echo '<img style="float: left; border: 1px solid #CCCCCC; margin: 0px auto; max-width: 125px; height: auto;" src="' . TS_VCSC_GetResourceURL('images/envato/envato_find_license_key.png') .'">';
										echo '</div>';
										echo '<div style="margin-left: 10px; margin: 10px 0 20px 10px; width: 100%; float: left;">Click on image to get directions to retrieve your Envato License Key.</div>';
									}
								} else {
									echo '<span id="Envato_Key_Missing" style="color: red;">Please enter your Purchase/License Key!</span>';
								}
							} else {
								if (strlen(get_option('ts_vcsc_extend_settings_license')) != 0) {
									echo get_option('ts_vcsc_extend_settings_licenseInfo');
									if (get_option('ts_vcsc_extend_settings_licenseValid') == 0) {
										echo '<div class="ts_vcsc_extend_messi_link clearFixMe" data-title="Retrieve your Envato License Code" data-source="' . TS_VCSC_GetResourceURL('images/envato/envato_find_license_key.png') .'" style="cursor: pointer; margin-left: 10px; margin-top: 10px;">';
											echo '<img style="float: left; border: 1px solid #CCCCCC; margin: 0px auto; max-width: 125px; height: auto;" src="' . TS_VCSC_GetResourceURL('images/envato/envato_find_license_key.png') .'">';
										echo '</div>';
										echo '<div style="margin-left: 10px; margin: 10px 0 20px 10px; width: 100%; float: left;">Click on image to get directions to retrieve your Envato License Key.</div>';
									}
								} else {
									echo '<span id="Envato_Key_Missing" style="color: red;">Please enter your Purchase/License Key!</span>';
								}
							}
						?>
						<div style="height: 20px; display: block;"></div>
					</div>
				</td>
			</tr>
		</table>
		<?php
			if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginIsMultiSiteActive == "true") {
				echo '<div id="ts-settings-summary" style="display: none;" data-extended="' . get_site_option('ts_vcsc_extend_settings_extended', 0) . '" data-summary="' . get_site_option('ts_vcsc_extend_settings_licenseKeyed', 'emptydelimiterfix') . '">' . get_site_option('ts_vcsc_extend_settings_licenseInfo', '') . '</div>';
			} else {
				echo '<div id="ts-settings-summary" style="display: none;" data-extended="' . get_option('ts_vcsc_extend_settings_extended', 0) . '" data-summary="' . get_option('ts_vcsc_extend_settings_licenseKeyed', 'emptydelimiterfix') . '">' . get_option('ts_vcsc_extend_settings_licenseInfo', '') . '</div>';
			}
		?>
	</div>
	<div class="ts-vcsc-extend-license-controls" style="width: 100%; margin-top: 20px;">		
		<?php		
			if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginIsMultiSiteActive == "true") {
				if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginValid == "true") {
					echo '<div class="ts-advanced-link-button-wrapper ts-advanced-link-tooltip-holder">
                        <span class="ts-advanced-link-tooltip-content">' . __("Click here to check your license for Composium - Visual Composer Extensions.", "ts_visual_composer_extend") . '</span>
                        <button type="submit" name="License" class="ts-advanced-link-button-main ts-advanced-link-button-blue ts-advanced-link-button-unlock" style="margin: 0;">' . __("Re-Check License", "ts_visual_composer_extend") . '</button>
                    </div>';
					echo '<div class="ts-advanced-link-button-wrapper ts-advanced-link-tooltip-holder ts-advanced-link-tooltip-right" style="float: right;">
                        <span class="ts-advanced-link-tooltip-content">' . __("Click here to unlicense this installation of Composium - Visual Composer Extensions.", "ts_visual_composer_extend") . '</span>
                        <button type="submit" name="Unlicense" class="ts-advanced-link-button-main ts-advanced-link-button-red ts-advanced-link-button-lock" style="margin: 0;">' . __("Unlicense Plugin", "ts_visual_composer_extend") . '</button>
                    </div>';
				} else {
					echo '<div class="ts-advanced-link-button-wrapper ts-advanced-link-tooltip-holder">
                        <span class="ts-advanced-link-tooltip-content">' . __("Click here to check your license for Composium - Visual Composer Extensions.", "ts_visual_composer_extend") . '</span>
                        <button type="submit" name="License" class="ts-advanced-link-button-main ts-advanced-link-button-blue ts-advanced-link-button-unlock" style="margin: 0;">' . __("Check License", "ts_visual_composer_extend") . '</button>
                    </div>';
				}
			} else {
				if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginValid == "true") {
					echo '<div class="ts-advanced-link-button-wrapper ts-advanced-link-tooltip-holder">
                        <span class="ts-advanced-link-tooltip-content">' . __("Click here to check your license for Composium - Visual Composer Extensions.", "ts_visual_composer_extend") . '</span>
                        <button type="submit" name="License" class="ts-advanced-link-button-main ts-advanced-link-button-blue ts-advanced-link-button-unlock" style="margin: 0;">' . __("Re-Check License", "ts_visual_composer_extend") . '</button>
                    </div>';
					echo '<div class="ts-advanced-link-button-wrapper ts-advanced-link-tooltip-holder ts-advanced-link-tooltip-right" style="float: right;">
                        <span class="ts-advanced-link-tooltip-content">' . __("Click here to unlicense this installation of Composium - Visual Composer Extensions.", "ts_visual_composer_extend") . '</span>
                        <button type="submit" name="Unlicense" class="ts-advanced-link-button-main ts-advanced-link-button-red ts-advanced-link-button-lock" style="margin: 0;">' . __("Unlicense Plugin", "ts_visual_composer_extend") . '</button>
                    </div>';
				} else {
					echo '<div class="ts-advanced-link-button-wrapper ts-advanced-link-tooltip-holder">
                        <span class="ts-advanced-link-tooltip-content">' . __("Click here to check your license for Composium - Visual Composer Extensions.", "ts_visual_composer_extend") . '</span>
                        <button type="submit" name="License" class="ts-advanced-link-button-main ts-advanced-link-button-blue ts-advanced-link-button-unlock" style="margin: 0;">' . __("Check License", "ts_visual_composer_extend") . '</button>
                    </div>';
				}
			}
		?>
	</div>
</form>