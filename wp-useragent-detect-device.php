<?php
/* Copyright 2008-2016  Kyle Baker  (email: kyleabaker@gmail.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// Security measure
defined( 'ABSPATH' ) or die( 'Cannot access pages directly.' );

// Detect Console or Mobile Device
function wpua_detect_device()
{
	global $useragent, $wpua_show_version;

	$version = null;

	// Apple
	if (preg_match('/iPad/i', $useragent))
	{
		$link = 'http://www.apple.com/itunes';
		$title = 'iPad';

		if (preg_match('/CPU\ OS\ ([._0-9a-zA-Z]+)/i', $useragent, $regmatch))
		{
			$version = 'iOS '.str_replace('_', '.', $regmatch[1]);
		}

		$code = 'ipad';
	}
	elseif (preg_match('/iPod/i', $useragent))
	{
		$link = 'http://www.apple.com/itunes';
		$title = 'iPod';

		if (preg_match('/iPhone\ OS\ ([._0-9a-zA-Z]+)/i', $useragent, $regmatch))
		{
			$version = 'iOS '.str_replace('_', '.', $regmatch[1]);
		}

		$code = 'iphone';
	}
	elseif (preg_match('/iPhone/i', $useragent) && !preg_match('/Windows Phone/i', $useragent))
	{
		$link = 'http://www.apple.com/iphone';
		$title = 'iPhone';

		if (preg_match('/iPhone\ OS\ ([._0-9a-zA-Z]+)/i', $useragent, $regmatch))
		{
			$version = 'iOS '.str_replace('_', '.', $regmatch[1]);
		}

		$code = 'iphone';
	}

	// BlackBerry
	elseif (preg_match('/BlackBerry/i', $useragent))
	{
		$link = 'http://www.blackberry.com/';
		$title = 'BlackBerry';

		if (preg_match('/blackberry([.0-9a-zA-Z]+)\//i', $useragent, $regmatch))
		{
			$version = $regmatch[1];
		}

		$code = 'blackberry';
	}

	// Google
	elseif (preg_match('/Nexus/i', $useragent))
	{
		$link = 'http://en.wikipedia.org/wiki/Google_Nexus';
		$title = 'Google Nexus';
		$code = 'google-nexus';
	}
	elseif (preg_match('/Pixel/i', $useragent))
	{
		$link = 'http://en.wikipedia.org/wiki/Pixel_(smartphone)';
		$title = 'Google Pixel';
		$code = 'google-pixel';
	}

	// HTC
	elseif (preg_match('/Desire/i', $useragent))
	{
		$link = 'http://en.wikipedia.org/wiki/HTC_Desire';
		$title = 'HTC Desire';
		$code = 'htc';
	}
	elseif (preg_match('/Rhodium/i', $useragent)
		|| preg_match('/HTC[_|\ ]Touch[_|\ ]Pro2/i', $useragent)
		|| preg_match('/WMD-50433/i', $useragent))
	{
		$link = 'http://en.wikipedia.org/wiki/HTC_Touch_Pro2';
		$title = 'HTC Touch Pro2';
		$code = 'htc';
	}
	elseif (preg_match('/HTC[_|\ ]Touch[_|\ ]Pro/i', $useragent))
	{
		$link = 'http://en.wikipedia.org/wiki/HTC_Touch_Pro';
		$title = 'HTC Touch Pro';
		$code = 'htc';
	}
	elseif (preg_match('/HTC/i', $useragent))
	{
		$link = 'http://en.wikipedia.org/wiki/High_Tech_Computer_Corporation';
		$title = 'HTC';

		if (preg_match('/HTC[\ |_|-]8500/i', $useragent))
		{
			$link = 'http://en.wikipedia.org/wiki/HTC_Startrek';
			$title .= ' Startrek';
		}
		elseif (preg_match('/HTC[\ |_|-]Hero/i', $useragent))
		{
			$link = 'http://en.wikipedia.org/wiki/HTC_Hero';
			$title .= ' Hero';
		}
		elseif (preg_match('/HTC[\ |_|-]Legend/i', $useragent))
		{
			$link = 'http://en.wikipedia.org/wiki/HTC_Legend';
			$title .= ' Legend';
		}
		elseif (preg_match('/HTC[\ |_|-]Magic/i', $useragent))
		{
			$link = 'http://en.wikipedia.org/wiki/HTC_Magic';
			$title .= ' Magic';
		}
		elseif (preg_match('/HTC[\ |_|-]P3450/i', $useragent))
		{
			$link = 'http://en.wikipedia.org/wiki/HTC_Touch';
			$title .= ' Touch';
		}
		elseif (preg_match('/HTC[\ |_|-]P3650/i', $useragent))
		{
			$link = 'http://en.wikipedia.org/wiki/HTC_Polaris';
			$title .= ' Polaris';
		}
		elseif (preg_match('/HTC[\ |_|-]S710/i', $useragent))
		{
			$link = 'http://en.wikipedia.org/wiki/HTC_S710';
			$title .= ' S710';
		}
		elseif (preg_match('/HTC[\ |_|-]Tattoo/i', $useragent))
		{
			$link = 'http://en.wikipedia.org/wiki/HTC_Tattoo';
			$title .= ' Tattoo';
		}
		elseif (preg_match('/HTC[\ |_|-]?([.0-9a-zA-Z]+)/i', $useragent, $regmatch))
		{
			$title .= ' '.$regmatch[1]; // Matche other HTC product names (possibly versions?)
		}
		elseif (preg_match('/HTC([._0-9a-zA-Z]+)/i', $useragent, $regmatch))
		{
			$title .= str_replace('_', ' ', $regmatch[1]);
		}

		$code = 'htc';
	}

	// Kindle
	elseif (preg_match('/Kindle/i', $useragent))
	{
		$link = 'http://en.wikipedia.org/wiki/Amazon_Kindle';
		$title = 'Kindle';

		if (preg_match('/Kindle\/([.0-9a-zA-Z]+)/i', $useragent, $regmatch))
		{
			$version = $regmatch[1];
		}

		$code = 'kindle';
	}

	// LG
	elseif (preg_match('/LG/i', $useragent))
	{
		$link = 'http://www.lgmobile.com';
		$title = 'LG';

		if (preg_match('/LG[E]?[\ |-|\/]([.0-9a-zA-Z]+)/i', $useragent, $regmatch))
		{
			$version = $regmatch[1];
		}

		$code = 'lg';
	}

	// Microsoft
	elseif (preg_match('/Windows Phone OS 7/i', $useragent)
		|| preg_match('/ZuneWP7/i', $useragent)
		|| preg_match('/WP7/i', $useragent))
	{
		$link = 'http://www.microsoft.com/windowsphone/';
		$title = 'Windows Phone';
		$version = '7';
		$code = 'wp7';
	}
	elseif (preg_match('/Windows Phone OS 8\.1/i', $useragent)
		|| preg_match('/Windows Phone 8\.1/i', $useragent)
		|| preg_match('/WP8\.1/i', $useragent))
	{
		$link = 'http://www.microsoft.com/windowsphone/';
		$title = 'Windows Phone';
		$version = '8.1';
		$code = 'wp81';
	}
	elseif (preg_match('/Windows Phone OS 8/i', $useragent)
		|| preg_match('/Windows Phone 8/i', $useragent)
		|| preg_match('/WP8/i', $useragent))
	{
		$link = 'http://www.microsoft.com/windowsphone/';
		$title = 'Windows Phone';
		$version = '8';
		$code = 'wp8';
	}
	elseif (preg_match('/Windows Phone 10/i', $useragent)
		|| preg_match('/WP10/i', $useragent))
	{
		$link = 'http://www.microsoft.com/windowsphone/';
		$title = 'Windows Phone';
		$version = '10';
		$code = 'wp10';
	}
	elseif (preg_match('/Xbox/i', $useragent))
	{
		$link = 'http://www.microsoft.com/windowsphone/';
		$title = 'Xbox';
		$code = 'xbox';

		if (preg_match('/Xbox360/i', $useragent, $regmatch)
			|| preg_match('/Xbox 360/i', $useragent, $regmatch))
		{
			$title .= ' 360';
			$code = 'xbox';
		}
		elseif (preg_match('/XboxOne/i', $useragent, $regmatch)
			|| preg_match('/XboxOne/i', $useragent, $regmatch))
		{
			$title .= ' One';
			$code = 'xboxone';
		}
	}

	// Motorola
	elseif (preg_match('/\ Droid/i', $useragent))
	{
		$link = 'http://en.wikipedia.org/wiki/Motorola_Droid';
		$title = 'Motorola Droid';
		$code = 'motorola';
	}
	elseif (preg_match('/XT720/i', $useragent))
	{
		$link = 'http://en.wikipedia.org/wiki/Motorola';
		$title = 'Motorola Motoroi (XT720)';
		$code = 'motorola';
	}
	elseif (preg_match('/MOT-/i', $useragent)
		|| preg_match('/MIB/i', $useragent))
	{
		$link = 'http://en.wikipedia.org/wiki/Motorola';
		$title = 'Motorola';

		if (preg_match('/MOTO([.0-9a-zA-Z]+)/i', $useragent, $regmatch))
		{
			$version = $regmatch[1];
		}
		if (preg_match('/MOT-([.0-9a-zA-Z]+)/i', $useragent, $regmatch))
		{
			$version = $regmatch[1];
		}

		$code = 'motorola';
	}
	elseif (preg_match('/XOOM/i', $useragent))
	{
		$link = 'http://en.wikipedia.org/wiki/Motorola_Xoom';
		$title = 'Motorola Xoom';
		$code = 'motorola';
	}

	// Nintendo
	elseif (preg_match('/Nintendo/i', $useragent))
	{
		$title = 'Nintendo';

		if (preg_match('/Nintendo 3DS/i', $useragent))
		{
			$link = 'http://www.nintendodsi.com/';
			$title .= ' 3DS';
			$code = 'nintendods';
		}
		elseif (preg_match('/Nintendo DSi/i', $useragent))
		{
			$link = 'http://www.nintendodsi.com/';
			$title .= ' DSi';
			$code = 'nintendodsi';
		}
		elseif (preg_match('/Nintendo DS/i', $useragent))
		{
			$link = 'http://www.nintendo.com/ds';
			$title .= ' DS';
			$code = 'nintendods';
		}
		elseif (preg_match('/Nintendo WiiU/i', $useragent))
		{
			$link = 'http://www.nintendo.com/wiiu';
			$title .= ' Wii U';
			$code = 'nintendowiiu';
		}
		elseif (preg_match('/Nintendo Wii/i', $useragent))
		{
			$link = 'http://www.nintendo.com/wii';
			$title .= ' Wii';
			$code = 'nintendowii';
		}
		else
		{
			$link = 'http://www.nintendo.com/';
			$code = 'nintendo';
		}
	}

	// Nokia
	elseif (preg_match('/Nokia/i', $useragent)
		&& !preg_match('/S(eries)?60/i', $useragent))
	{
		$link = 'http://www.nokia.com/';
		$title = 'Nokia';
		if (preg_match('/Nokia(E|N)?([0-9]+)/i', $useragent, $regmatch))
			$title .= ' '.$regmatch[1].$regmatch[2]; // Model name
		$code = 'nokia';
	}
	elseif (preg_match('/S(eries)?60/i', $useragent))
	{
		$link = 'http://www.s60.com/';
		$title = 'Nokia Series60';
		$code = 'nokia';
	}

	// Playstation
	elseif (preg_match('/PlayStation/i', $useragent))
	{
		$title = 'PlayStation';

		if (preg_match('/[PS|PlayStation\ ]3/i', $useragent))
		{
			$link = 'http://www.us.playstation.com/PS3';
			$title .= ' 3';
		}
		elseif (preg_match('/[PS|PlayStation\ ]4/i', $useragent))
		{
			$link = 'http://www.us.playstation.com/PS4';
			$title .= ' 4';
		}
		elseif (preg_match('/[PlayStation Portable|PSP]/i', $useragent))
		{
			$link = 'http://www.us.playstation.com/PSP';
			$title .= ' Portable';
		}
		elseif (preg_match('/[PlayStation Vita|PSVita]/i', $useragent))
		{
			$link = 'http://us.playstation.com/psvita/';
			$title .= ' Vita';
		}
		else
		{
			$link = 'http://www.us.playstation.com/';
		}

		$code = 'playstation';
	}

	// Samsung
	elseif (preg_match('/Galaxy Nexus/i', $useragent))
	{
		$link = 'http://en.wikipedia.org/wiki/Galaxy_Nexus';
		$title = 'Galaxy Nexus';
		$code = 'samsung';
	}
	elseif (preg_match('/SmartTV/i', $useragent))
	{
		$link = 'http://www.freethetvchallenge.com/details/faq';
		$title = 'Samsung Smart TV';
		$code = 'samsung';
	}
	elseif (preg_match('/Samsung/i', $useragent))
	{
		$link = 'http://www.samsungmobile.com/';
		$title = 'Samsung';

		if (preg_match('/Samsung-([.\-0-9a-zA-Z]+)/i', $useragent, $regmatch))
		{
			$title .= ' '.$regmatch[1];
		}

		$code = 'samsung';
	}

	// Sony Ericsson
	elseif (preg_match('/SonyEricsson/i', $useragent))
	{
		$link = 'http://en.wikipedia.org/wiki/SonyEricsson';
		$title = 'Sony Ericsson';

		if (preg_match('/SonyEricsson([.0-9a-zA-Z]+)/i', $useragent, $regmatch))
		{
			if (strtolower($regmatch[1]) === strtolower('U20i'))
			{
				$title .= ' Xperia X10 Mini Pro';
			}
			else
			{
				$title .= ' '.$regmatch[1];
			}
		}

		$code = 'sonyericsson';
	}

	// Ubuntu Phone/Tablet
	elseif (preg_match('/Ubuntu\;\ Mobile/i', $useragent))
	{
		$link = 'http://www.ubuntu.com/phone';
		$title = 'Ubuntu Phone';
		$code = 'ubuntutouch';
	}
	elseif (preg_match('/Ubuntu\;\ Tablet/i', $useragent))
	{
		$link = 'http://www.ubuntu.com/tablet';
		$title = 'Ubuntu Tablet';
		$code = 'ubuntutouch';
	}

	// Windows Phone
	elseif (preg_match('/wp-windowsphone/i', $useragent))
	{
		$link = 'http://www.windowsphone.com/';
		$title = 'Windows Phone';
		$code = 'windowsphone';
	}

	// No Device match
	else
	{
		return '';
	}

	// Append version to title (as long as show version isn't 'off')
	if (isset($version) && $wpua_show_version !== 'false')
	{
		$title .= " $version";
	}

	return wpua_get_icon_text($link, $title, $code, '/device/');
}

?>
