<?php

/**
 *
 *
 * This is the denied.php model for jobgrokapp
 *
 * Created: November 18, 2014, 3:25 am
 *
 * Subversion Details
 * $Date: 2013-12-04 20:43:49 -0600 (Wed, 04 Dec 2013) $
 * $Revision: 5651 $
 * $Author: jobgrok $
 *
 * @author TK Tek, LLC. info@jobgrok.com
 * @version 3.1-1.2.55
 * @package com_jobgrokapp
 *
 * @copyright Copyright {c} 2008-2014
 * @license GNU Public License Version 2
 *
 * This file is part of JobGrok.
 *
 * JobGrok is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * (at your option) any later version.
 *
 * JobGrok is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with JobGrok.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');
jimport('joomla.html.html');

class JobgrokappModelDenied extends JModelLegacy

{
    // our constructor, a little more interesting...
    function __construct()
    {
        parent :: __construct();

    }

}

?>