<?php

/**
 *
 * This is the router file (SEF) for jobgrokapp
 *
 * Created: November 18, 2014, 3:25 am
 *
 * Subversion Details
 * $Date: 2013-09-19 10:33:21 -0500 (Thu, 19 Sep 2013) $
 * $Revision: 5490 $
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

jimport( 'joomla.html.parameter');
function JobgrokappBuildRoute(& $query) {
    $segments = array();
    if (isset($query['view'])) {
        $segments[] = $query['view'];
        unset($query['view']);
    }
    if (isset($query['id'])) {
        $vals = explode(':', $query['id']);
        if (count($vals) > 1) {
            list($id, $title) = $vals;
            $segments[] = (int)$id;
            $segments[] = $title;
        } else {
            $segments[] = $vals[0];
        }
        //list($id, $title) = explode(':', $query['id'], 2);
        //$segments[] = (int)$id;
        //$segments[] = $title;
        unset($query['id']);
    };
    /*
    if (isset($query['layout'])) {
        $segments[] = $query['layout'];
        unset($query['layout']);
    }
     */
    return $segments;
}

function JobgrokappParseRoute($segments) {
    $vars = array();
    switch ($segments[0]) {
        case 'application':
            $vars['view'] = 'application';
            // if (isset($segments[1])) $vars['layout'] = $segments[1];
            break;
        default:
            break;        
    }
    return $vars;
}

?>
