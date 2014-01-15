<?php
//============================================================+
// File name   : qrcode.php
// Begin       : 2010-03-22
// Last Update : 2010-03-30
// Version     : 1.0.003
// License     : GNU LGPL v.3 (http://www.gnu.org/copyleft/lesser.html)
// 	----------------------------------------------------------------------------
//
// 	This library is free software; you can redistribute it and/or
// 	modify it under the terms of the GNU Lesser General Public
// 	License as published by the Free Software Foundation; either
// 	version 3 of the License, or any later version.
//
// 	This library is distributed in the hope that it will be useful,
// 	but WITHOUT ANY WARRANTY; without even the implied warranty of
// 	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
// 	Lesser General Public License for more details.
//
// 	You should have received a copy of the GNU Lesser General Public
// 	License along with this library; if not, write to the Free Software
// 	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
//  or browse http://www.gnu.org/copyleft/lesser.html
//
//  ----------------------------------------------------------------------------
//
// DESCRIPTION :
//
// Class to create QR-code arrays for TCPDF class.
// QR Code symbol is a 2D barcode that can be scanned by
// handy terminals such as a mobile phone with CCD.
// The capacity of QR Code is up to 7000 digits or 4000
// characters, and has high robustness.
// This class supports QR Code model 2, described in
// JIS (Japanese Industrial Standards) X0510:2004
// or ISO/IEC 18004.
// Currently the following features are not supported:
// ECI and FNC1 mode, Micro QR Code, QR Code model 1,
// Structured mode.
//
// This class is derived from the following projects:
// ---------------------------------------------------------
// "PHP QR Code encoder"
// License: GNU-LGPLv3
// Copyright (C) 2010 by Dominik Dzienia <deltalab at poczta dot fm>
// http://phpqrcode.sourceforge.net/
// https://sourceforge.net/projects/phpqrcode/
//
// The "PHP QR Code encoder" is based on
// "C libqrencode library" (ver. 3.1.1)
// License: GNU-LGPL 2.1
// Copyright (C) 2006-2010 by Kentaro Fukuchi
// http://megaui.net/fukuchi/works/qrencode/index.en.html
//
// Reed-Solomon code encoder is written by Phil Karn, KA9Q.
// Copyright (C) 2002-2006 Phil Karn, KA9Q
//
// QR Code is registered trademark of DENSO WAVE INCORPORATED
// http://www.denso-wave.com/qrcode/index-e.html
// ---------------------------------------------------------
//
// Author: Nicola Asuni
//
// (c) Copyright 2010:
//               Nicola Asuni
//               Tecnick.com S.r.l.
//               Via della Pace, 11
//               09044 Quartucciu (CA)
//               ITALY
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Class to create QR-code arrays for TCPDF class.
 * QR Code symbol is a 2D barcode that can be scanned by handy terminals such as a mobile phone with CCD.
 * The capacity of QR Code is up to 7000 digits or 4000 characters, and has high robustness.
 * This class supports QR Code model 2, described in JIS (Japanese Industrial Standards) X0510:2004 or ISO/IEC 18004.
 * Currently the following features are not supported: ECI and FNC1 mode, Micro QR Code, QR Code model 1, Structured mode.
 *
 * This class is derived from "PHP QR Code encoder" by Dominik Dzienia (http://phpqrcode.sourceforge.net/) based on "libqrencode C library 3.1.1." by Kentaro Fukuchi (http://megaui.net/fukuchi/works/qrencode/index.en.html), contains Reed-Solomon code written by Phil Karn, KA9Q. QR Code is registered trademark of DENSO WAVE INCORPORATED (http://www.denso-wave.com/qrcode/index-e.html).
 * Please read comments on this class source file for full copyright and license information.
 *
 * @package com.tecnick.tcpdf
 * @abstract Class for generating QR-code array for TCPDF.
 * @author Nicola Asuni
 * @copyright 2010 Nicola Asuni - Tecnick.com S.r.l (www.tecnick.com) Via Della Pace, 11 - 09044 - Quartucciu (CA) - ITALY - www.tecnick.com - info@tecnick.com
 * @link http://www.tcpdf.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 * @version 1.0.003
 */

// definitions
if (!defined('QRCODEDEFS')) {

	/**
	 * Indicate that definitions for this class are set
	 */
	define('QRCODEDEFS', true);

	// -----------------------------------------------------

	// Encoding modes (characters which can be encoded in QRcode)

	/**
	 * Encoding mode
	 */
	define('QR_MODE_NL', -1);

	/**
	 * Encoding mode numeric (0-9). 3 characters are encoded to 10bit length. In theory, 7089 characters or less can be stored in a QRcode.
	 */
	define('QR_MODE_NM', 0);

	/**
	 * Encoding mode alphanumeric (0-9A-Z $%*+-./:) 45characters. 2 characters are encoded to 11bit length. In theory, 4296 characters or less can be stored in a QRcode.
	 */
	define('QR_MODE_AN', 1);

	/**
	 * Encoding mode 8bit byte data. In theory, 2953 characters or less can be stored in a QRcode.
	 */
	define('QR_MODE_8B', 2);

	/**
	 * Encoding mode KANJI. A KANJI character (multibyte character) is encoded to 13bit length. In theory, 1817 characters or less can be stored in a QRcode.
	 */
	define('QR_MODE_KJ', 3);

	/**
	 * Encoding mode STRUCTURED (currently unsupported)
	 */
	define('QR_MODE_ST', 4);

	// -----------------------------------------------------

	// Levels of error correction.
	// QRcode has a function of an error correcting for miss reading that white is black.
	// Error correcting is defined in 4 level as below.

	/**
	 * Error correction level L : About 7% or less errors can be corrected.
	 */
	define('QR_ECLEVEL_L', 0);

	/**
	 * Error correction level M : About 15% or less errors can be corrected.
	 */
	define('QR_ECLEVEL_M', 1);

	/**
	 * Error correction level Q : About 25% or less errors can be corrected.
	 */
	define('QR_ECLEVEL_Q', 2);

	/**
	 * Error correction level H : About 30% or less errors can be corrected.
	 */
	define('QR_ECLEVEL_H', 3);

	// -----------------------------------------------------

	// Version. Size of QRcode is defined as version.
	// Version is from 1 to 40.
	// Version 1 is 21*21 matrix. And 4 modules increases whenever 1 version increases.
	// So version 40 is 177*177 matrix.

	/**
	 * Maximum QR Code version.
	 */
	define('QRSPEC_VERSION_MAX', 40);

	/**
	 * Maximum matrix size for maximum version (version 40 is 177*177 matrix).
	 */
    define('QRSPEC_WIDTH_MAX', 177);

	// -----------------------------------------------------

	/**
	 * Matrix index to get width from $capacity array.
	 */
    define('QRCAP_WIDTH',    0);

    /**
	 * Matrix index to get number of words from $capacity array.
	 */
    define('QRCAP_WORDS',    1);

    /**
	 * Matrix index to get remainder from $capacity array.
	 */
    define('QRCAP_REMINDER', 2);

    /**
	 * Matrix index to get error correction level from $capacity array.
	 */
    define('QRCAP_EC',       3);

	// -----------------------------------------------------

	// Structure (currently usupported)

	/**
	 * Number of header bits for structured mode
	 */
    define('STRUCTURE_HEADER_BITS',  20);

    /**
	 * Max number of symbols for structured mode
	 */
    define('MAX_STRUCTURED_SYMBOLS', 16);

	// -----------------------------------------------------

    // Masks

    /**
	 * Down point base value for case 1 mask pattern (concatenation of same color in a line or a column)
	 */
    define('N1',  3);

    /**
	 * Down point base value for case 2 mask pattern (module block of same color)
	 */
	define('N2',  3);

    /**
	 * Down point base value for case 3 mask pattern (1:1:3:1:1(dark:bright:dark:bright:dark)pattern in a line or a column)
	 */
	define('N3', 40);

    /**
	 * Down point base value for case 4 mask pattern (ration of dark modules in whole)
	 */
	define('N4', 10);

	// -----------------------------------------------------

	// Optimization settings

	/**
	 * if true, estimates best mask (spec. default, but extremally slow; set to false to significant performance boost but (propably) worst quality code
	 */
	define('QR_FIND_BEST_MASK', true);

	/**
	 * if false, checks all masks available, otherwise value tells count of masks need to be checked, mask id are got randomly
	 */
	define('QR_FIND_FROM_RANDOM', 2);

	/**
	 * when QR_FIND_BEST_MASK === false
	 */
	define('QR_DEFAULT_MASK', 2);

	// -----------------------------------------------------

} // end of definitions

// #*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#

if (!class_exists('QRcode', false)) {

	// for compaibility with PHP4
	if (!function_exists('str_split')) {
    	/**
    	 * Convert a string to an array (needed for PHP4 compatibility)
    	 * @param string $string The input string.
    	 * @param int $split_length Maximum length of the chunk.
    	 * @return  If the optional split_length  parameter is specified, the returned array will be broken down into chunks with each being split_length  in length, otherwise each chunk will be one character in length. FALSE is returned if split_length is less than 1. If the split_length length exceeds the length of string , the entire string is returned as the first (and only) array element.
    	 */
		function str_split($string, $split_length=1) {
			if ((strlen($string) > $split_length) OR (!$split_length)) {
				do {
					$c = strlen($string);
					$parts[] = substr($string, 0, $split_length);
					$string = substr($string, $split_length);
				} while ($string !== false);
			} else {
				$parts = array($string);
			}
			return $parts;
		}
	}

	// #####################################################

	/**
	 * Class to create QR-code arrays for TCPDF class.
	 * QR Code symbol is a 2D barcode that can be scanned by handy terminals such as a mobile phone with CCD.
	 * The capacity of QR Code is up to 7000 digits or 4000 characters, and has high robustness.
	 * This class supports QR Code model 2, described in JIS (Japanese Industrial Standards) X0510:2004 or ISO/IEC 18004.
	 * Currently the following features are not supported: ECI and FNC1 mode, Micro QR Code, QR Code model 1, Structured mode.
	 *
	 * This class is derived from "PHP QR Code encoder" by Dominik Dzienia (http://phpqrcode.sourceforge.net/) based on "libqrencode C library 3.1.1." by Kentaro Fukuchi (http://megaui.net/fukuchi/works/qrencode/index.en.html), contains Reed-Solomon code written by Phil Karn, KA9Q. QR Code is registered trademark of DENSO WAVE INCORPORATED (http://www.denso-wave.com/qrcode/index-e.html).
	 * Please read comments on this class source file for full copyright and license information.
	 *
	 * @name QRcode
	 * @package com.tecnick.tcpdf
	 * @abstract Class for generating QR-code array for TCPDF.
	 * @author Nicola Asuni
	 * @copyright 2010 Nicola Asuni - Tecnick.com S.r.l (www.tecnick.com) Via Della Pace, 11 - 09044 - Quartucciu (CA) - ITALY - www.tecnick.com - info@tecnick.com
	 * @link http://www.tcpdf.org
	 * @license http://www.gnu.org/copyleft/lesser.html LGPL
	 * @version 1.0.002
	 */
	class QRcode {

		/**
		 * @var barcode array to be returned which is readable by TCPDF
		 * @access protected
		 */
		protected $barcode_array = array();

		/**
		 * @var QR code version. Size of QRcode is defined as version. Version is from 1 to 40. Version 1 is 21*21 matrix. And 4 modules increases whenever 1 version increases. So version 40 is 177*177 matrix.
		 * @access protected
		 */
		protected $version = 0;

		/**
		 * @var Levels of error correction. See definitions for possible values.
		 * @access protected
		 */
		protected $level = QR_ECLEVEL_L;

		/**
		 * @var Encoding mode
		 * @access protected
		 */
		protected $hint = QR_MODE_8B;

		/**
		 * @var if true the input string will be converted to uppercase
		 * @access protected
		 */
		protected $casesensitive = true;

		/**
		 * @var structured QR code (not supported yet)
		 * @access protected
		 */
		protected $structured = 0;

		/**
		 * @var mask data
		 * @access protected
		 */
		protected $data;

		// FrameFiller

		/**
		 * @var width
		 * @access protected
		 */
		protected $width;

		/**
		 * @var frame
		 * @access protected
		 */
		protected $frame;

		/**
		 * @var X position of bit
		 * @access protected
		 */
		protected $x;

		/**
		 * @var Y position of bit
		 * @access protected
		 */
		protected $y;

		/**
		 * @var direction
		 * @access protected
		 */
		protected $dir;

		/**
		 * @var single bit
		 * @access protected
		 */
		protected $bit;

		// ---- QRrawcode ----

		/**
		 * @var data code
		 * @access protected
		 */
		protected $datacode = array();

		/**
		 * @var error correction code
		 * @access protected
		 */
		protected $ecccode = array();

		/**
		 * @var blocks
		 * @access protected
		 */
		protected $blocks;

		/**
		 * @var Reed-Solomon blocks
		 * @access protected
		 */
		protected $rsblocks = array(); //of RSblock

		/**
		 * @var counter
		 * @access protected
		 */
		protected $count;

		/**
		 * @var data length
		 * @access protected
		 */
		protected $dataLength;

		/**
		 * @var error correction length
		 * @access protected
		 */
		protected $eccLength;

		/**
		 * @var b1
		 * @access protected
		 */
		protected $b1;

		// ---- QRmask ----

		/**
		 * @var run length
		 * @access protected
		 */
		protected $runLength = array();

		// ---- QRsplit ----

		/**
		 * @var input data string
		 * @access protected
		 */
		protected $dataStr = '';

		/**
		 * @var input items
		 * @access protected
		 */
		protected $items;

		// Reed-Solomon items

		/**
		 * @var Reed-Solomon items
		 * @access protected
		 */
		protected $rsitems = array();

		/**
		 * @var array of frames
		 * @access protected
		 */
		protected $frames = array();

		/**
		 * @var alphabet-numeric convesion table
		 * @access protected
		 */
		protected $anTable = array(
			-1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, //
			-1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, //
			36, -1, -1, -1, 37, 38, -1, -1, -1, -1, 39, 40, -1, 41, 42, 43, //
			 0,  1,  2,  3,  4,  5,  6,  7,  8,  9, 44, -1, -1, -1, -1, -1, //
			-1, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, //
			25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, -1, -1, -1, -1, -1, //
			-1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, //
			-1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1  //
			);

		/**
		 * @var array Table of the capacity of symbols
		 * See Table 1 (pp.13) and Table 12-16 (pp.30-36), JIS X0510:2004.
		 * @access protected
		 */
		protected $capacity = array(
			array(  0,    0, 0, array(   0,    0,    0,    0)), //
			array( 21,   26, 0, array(   7,   10,   13,   17)), //  1
			array( 25,   44, 7, array(  10,   16,   22,   28)), //
			array( 29,   70, 7, array(  15,   26,   36,   44)), //
			array( 33,  100, 7, array(  20,   36,   52,   64)), //
			array( 37,  134, 7, array(  26,   48,   72,   88)), //  5
			array( 41,  172, 7, array(  36,   64,   96,  112)), //
			array( 45,  196, 0, array(  40,   72,  108,  130)), //
			array( 49,  242, 0, array(  48,   88,  132,  156)), //
			array( 53,  292, 0, array(  60,  110,  160,  192)), //
			array( 57,  346, 0, array(  72,  130,  192,  224)), // 10
			array( 61,  404, 0, array(  80,  150,  224,  264)), //
			array( 65,  466, 0, array(  96,  176,  260,  308)), //
			array( 69,  532, 0, array( 104,  198,  288,  352)), //
			array( 73,  581, 3, array( 120,  216,  320,  384)), //
			array( 77,  655, 3, array( 132,  240,  360,  432)), // 15
			array( 81,  733, 3, array( 144,  280,  408,  480)), //
			array( 85,  815, 3, array( 168,  308,  448,  532)), //
			array( 89,  901, 3, array( 180,  338,  504,  588)), //
			array( 93,  991, 3, array( 196,  364,  546,  650)), //
			array( 97, 1085, 3, array( 224,  416,  600,  700)), // 20
			array(101, 1156, 4, array( 224,  442,  644,  750)), //
			array(105, 1258, 4, array( 252,  476,  690,  816)), //
			array(109, 1364, 4, array( 270,  504,  750,  900)), //
			array(113, 1474, 4, array( 300,  560,  810,  960)), //
			array(117, 1588, 4, array( 312,  588,  870, 1050)), // 25
			array(121, 1706, 4, array( 336,  644,  952, 1110)), //
			array(125, 1828, 4, array( 360,  700, 1020, 1200)), //
			array(129, 1921, 3, array( 390,  728, 1050, 1260)), //
			array(133, 2051, 3, array( 420,  784, 1140, 1350)), //
			array(137, 2185, 3, array( 450,  812, 1200, 1440)), // 30
			array(141, 2323, 3, array( 480,  868, 1290, 1530)), //
			array(145, 2465, 3, array( 510,  924, 1350, 1620)), //
			array(149, 2611, 3, array( 540,  980, 1440, 1710)), //
			array(153, 2761, 3, array( 570, 1036, 1530, 1800)), //
			array(157, 2876, 0, array( 570, 1064, 1590, 1890)), // 35
			array(161, 3034, 0, array( 600, 1120, 1680, 1980)), //
			array(165, 3196, 0, array( 630, 1204, 1770, 2100)), //
			array(169, 3362, 0, array( 660, 1260, 1860, 2220)), //
			array(173, 3532, 0, array( 720, 1316, 1950, 2310)), //
			array(177, 3706, 0, array( 750, 1372, 2040, 2430))  // 40
		);

		/**
		 * @var array Length indicator
		 * @access protected
		 */
		protected $lengthTableBits = array(
			array(10, 12, 14),
			array( 9, 11, 13),
			array( 8, 16, 16),
			array( 8, 10, 12)
		);

		/**
		 * @var array Table of the error correction code (Reed-Solomon block)
		 * See Table 12-16 (pp.30-36), JIS X0510:2004.
		 * @access protected
		 */
		protected $eccTable = array(
			array(array( 0,  0), array( 0,  0), array( 0,  0), array( 0,  0)), //
			array(array( 1,  0), array( 1,  0), array( 1,  0), array( 1,  0)), //  1
			array(array( 1,  0), array( 1,  0), array( 1,  0), array( 1,  0)), //
			array(array( 1,  0), array( 1,  0), array( 2,  0), array( 2,  0)), //
			array(array( 1,  0), array( 2,  0), array( 2,  0), array( 4,  0)), //
			array(array( 1,  0), array( 2,  0), array( 2,  2), array( 2,  2)), //  5
			array(array( 2,  0), array( 4,  0), array( 4,  0), array( 4,  0)), //
			array(array( 2,  0), array( 4,  0), array( 2,  4), array( 4,  1)), //
			array(array( 2,  0), array( 2,  2), array( 4,  2), array( 4,  2)), //
			array(array( 2,  0), array( 3,  2), array( 4,  4), array( 4,  4)), //
			array(array( 2,  2), array( 4,  1), array( 6,  2), array( 6,  2)), // 10
			array(array( 4,  0), array( 1,  4), array( 4,  4), array( 3,  8)), //
			array(array( 2,  2), array( 6,  2), array( 4,  6), array( 7,  4)), //
			array(array( 4,  0), array( 8,  1), array( 8,  4), array(12,  4)), //
			array(array( 3,  1), array( 4,  5), array(11,  5), array(11,  5)), //
			array(array( 5,  1), array( 5,  5), array( 5,  7), array(11,  7)), // 15
			array(array( 5,  1), array( 7,  3), array(15,  2), array( 3, 13)), //
			array(array( 1,  5), array(10,  1), array( 1, 15), array( 2, 17)), //
			array(array( 5,  1), array( 9,  4), array(17,  1), array( 2, 19)), //
			array(array( 3,  4), array( 3, 11), array(17,  4), array( 9, 16)), //
			array(array( 3,  5), array( 3, 13), array(15,  5), array(15, 10)), // 20
			array(array( 4,  4), array(17,  0), array(17,  6), array(19,  6)), //
			array(array( 2,  7), array(17,  0), array( 7, 16), array(34,  0)), //
			array(array( 4,  5), array( 4, 14), array(11, 14), array(16, 14)), //
			array(array( 6,  4), array( 6, 14), array(11, 16), array(30,  2)), //
			array(array( 8,  4), array( 8, 13), array( 7, 22), array(22, 13)), // 25
			array(array(10,  2), array(19,  4), array(28,  6), array(33,  4)), //
			array(array( 8,  4), array(22,  3), array( 8, 26), array(12, 28)), //
			array(array( 3, 10), array( 3, 23), array( 4, 31), array(11, 31)), //
			array(array( 7,  7), array(21,  7), array( 1, 37), array(19, 26)), //
			array(array( 5, 10), array(19, 10), array(15, 25), array(23, 25)), // 30
			array(array(13,  3), array( 2, 29), array(42,  1), array(23, 28)), //
			array(array(17,  0), array(10, 23), array(10, 35), array(19, 35)), //
			array(array(17,  1), array(14, 21), array(29, 19), array(11, 46)), //
			array(array(13,  6), array(14, 23), array(44,  7), array(59,  1)), //
			array(array(12,  7), array(12, 26), array(39, 14), array(22, 41)), // 35
			array(array( 6, 14), array( 6, 34), array(46, 10), array( 2, 64)), //
			array(array(17,  4), array(29, 14), array(49, 10), array(24, 46)), //
			array(array( 4, 18), array(13, 32), array(48, 14), array(42, 32)), //
			array(array(20,  4), array(40,  7), array(43, 22), array(10, 67)), //
			array(array(19,  6), array(18, 31), array(34, 34), array(20, 61))  // 40
		);

		/**
		 * @var array Positions of alignment patterns.
		 * This array includes only the second and the third position of the alignment patterns. Rest of them can be calculated from the distance between them.
		 * See Table 1 in Appendix E (pp.71) of JIS X0510:2004.
		 * @access protected
		 */
		protected $alignmentPattern = array(
			array( 0,  0),
			array( 0,  0), array(18,  0), array(22,  0), array(26,  0), array(30,  0), //  1- 5
			array(34,  0), array(22, 38), array(24, 42), array(26, 46), array(28, 50), //  6-10
			array(30, 54), array(32, 58), array(34, 62), array(26, 46), array(26, 48), // 11-15
			array(26, 50), array(30, 54), array(30, 56), array(30, 58), array(34, 62), // 16-20
			array(28, 50), array(26, 50), array(30, 54), array(28, 54), array(32, 58), // 21-25
			array(30, 58), array(34, 62), array(26, 50), array(30, 54), array(26, 52), // 26-30
			array(30, 56), array(34, 60), array(30, 58), array(34, 62), array(30, 54), // 31-35
			array(24, 50), array(28, 54), array(32, 58), array(26, 54), array(30, 58)  // 35-40
		);

		/**
		 * @var array Version information pattern (BCH coded).
		 * See Table 1 in Appendix D (pp.68) of JIS X0510:2004.
		 * size: [QRSPEC_VERSION_MAX - 6]
		 * @access protected
		 */
		protected $versionPattern = array(
			0x07c94, 0x085bc, 0x09a99, 0x0a4d3, 0x0bbf6, 0x0c762, 0x0d847, 0x0e60d, //
			0x0f928, 0x10b78, 0x1145d, 0x12a17, 0x13532, 0x149a6, 0x15683, 0x168c9, //
			0x177ec, 0x18ec4, 0x191e1, 0x1afab, 0x1b08e, 0x1cc1a, 0x1d33f, 0x1ed75, //
			0x1f250, 0x209d5, 0x216f0, 0x228ba, 0x2379f, 0x24b0b, 0x2542e, 0x26a64, //
			0x27541, 0x28c69
		);

		/**
		 * @var array Format information
		 * @access protected
		 */
		protected $formatInfo = array(
			array(0x77c4, 0x72f3, 0x7daa, 0x789d, 0x662f, 0x6318, 0x6c41, 0x6976), //
			array(0x5412, 0x5125, 0x5e7c, 0x5b4b, 0x45f9, 0x40ce, 0x4f97, 0x4aa0), //
			array(0x355f, 0x3068, 0x3f31, 0x3a06, 0x24b4, 0x2183, 0x2eda, 0x2bed), //
			array(0x1689, 0x13be, 0x1ce7, 0x19d0, 0x0762, 0x0255, 0x0d0c, 0x083b)  //
		);


		// -------------------------------------------------
		// -------------------------------------------------


		/**
		 * This is the class constructor.
		 * Creates a QRcode object
		 * @param string $code code to represent using QRcode
		 * @param string $eclevel error level: <ul><li>L : About 7% or less errors can be corrected.</li><li>M : About 15% or less errors can be corrected.</li><li>Q : About 25% or less errors can be corrected.</li><li>H : About 30% or less errors can be corrected.</li></ul>
		 * @access public
		 * @since 1.0.000
		 */
		public function __construct($code, $eclevel = 'L') {
			$barcode_array = array();
			if ((is_null($code)) OR ($code == '\0') OR ($code == '')) {
				return false;
			}
			// set error correction level
			$this->level = array_search($eclevel, array('L', 'M', 'Q', 'H'));
			if ($this->level === false) {
				$this->level = QR_ECLEVEL_L;
			}
			if (($this->hint != QR_MODE_8B) AND ($this->hint != QR_MODE_KJ)) {
				return false;
			}
			if (($this->version < 0) OR ($this->version > QRSPEC_VERSION_MAX)) {
				return false;
			}
			$this->items = array();
			$this->encodeString($code);
			$qrTab = $this->binarize($this->data);
			$size = count($qrTab);
			$barcode_array['num_rows'] = $size;
			$barcode_array['num_cols'] = $size;
			$barcode_array['bcode'] = array();
			foreach ($qrTab as $line) {
				$arrAdd = array();
				foreach (str_split($line) as $char) {
					$arrAdd[] = ($char=='1')?1:0;
				}
				$barcode_array['bcode'][] = $arrAdd;
			}
			$this->barcode_array = $barcode_array;
		}

		/**
		 * Returns a barcode array which is readable by TCPDF
		 * @return array barcode array readable by TCPDF;
		 * @access public
		 */
		public function getBarcodeArray() {
			return $this->barcode_array;
		}

		/**
		 * Convert the frame in binary form
		 * @param array $frame array to binarize
		 * @return array frame in binary form
		 */
		protected function binarize($frame) {
			$len = count($frame);
			// the frame is square (width = height)
			foreach ($frame as &$frameLine) {
				for ($i=0; $i<$len; $i++) {
					$frameLine[$i] = (ord($frameLine[$i])&1)?'1':'0';
				}
			}
			return $frame;
		}

		/**
		 * Encode the input string to QR code
		 * @param string $string input string to encode
		 */
		protected function encodeString($string) {
			$this->dataStr = $string;
			if (!$this->casesensitive) {
				$this->toUpper();
			}
			$ret = $this->splitString();
			if ($ret < 0) {
				return NULL;
			}
			$this->encodeMask(-1);
		}

		/**
		 * Encode mask
		 * @param int $mask masking mode
		 */
		protected function encodeMask($mask) {
			$spec = array(0, 0, 0, 0, 0);
			$this->datacode = $this->getByteStream($this->items);
			if (is_null($this->datacode)) {
				return NULL;
			}
			$spec = $this->getEccSpec($this->version, $this->level, $spec);
			$this->b1 = $this->rsBlockNum1($spec);
			$this->dataLength = $this->rsDataLength($spec);
			$this->eccLength = $this->rsEccLength($spec);
			$this->ecccode = array_fill(0, $this->eccLength, 0);
			$this->block