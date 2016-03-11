<?php

/**
 *
 *
 * This is the staticreferral.php controller for jobgrokapp
 *
 * Created: November 18, 2014, 3:25 am
 *
 * Subversion Details
 * $Date: 2010-04-16 19:42:38 -0500 (Fri, 16 Apr 2010) $
 * $Revision: 1784 $
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

/**
 *
 * Job Type Model
 *
 */

class JobgrokappModelStaticReferral extends JModelLegacy

{
/**
 *
 * Job Type Id
 *
 * @var int
 *
 */
    var $_id;

    /**
     *
     * Job Type Data
     *
     * @var object
     *
     */
    var $_referral;

    /**
     * Items total
     * @var integer
     */
    var $_total = null;

    /**
     * Pagination object
     * @var object
     */
    var $_pagination = null;

    /**
     *
     * Set query to pull data
     *
     */
    function _buildQuery()
    {
        $query = 'SELECT jt.* FROM #__tst_jgapp_static_referral jt ORDER BY id';
        return $query;
    }

    /**
     *
     * Retrieves the categories data
     *
     * @return array Array of objects containing job types data
     *
     */
    function & getData()
    {
        if (empty ($this->_referral))
        {
            $query = $this->_buildQuery();
            $limitstart = $this->getState('limitstart');
            $limit = $this->getState('limit');
            $this->_referral = $this->_getList($query, $limitstart, $limit);
        }
        return $this->_referral;
    }

    /**
     * Method to set the job type identifier
     *
     * @access    public
     * @param    int Job Type identifier
     * @return    void
     */
    function setId($id)
    {
    // Set id and wipe data
        $this->_id = $id;
        $this->_referral = null;
    }
    /**
     *
     * Constructor
     *
     */
    function __construct()
    {
        parent :: __construct();

        // get the cid array from the default request hash
        $cid = JRequest :: getVar('cid', false, 'DEFAULT', 'array');
        if ($cid)
        {
            $id = $cid[0];
        }
        else
        {
            $id = JRequest :: getInt('id', 0);
        }
        $this->setId($id);

        global $option;
        $mainframe = JFactory::getApplication();

        // Get pagination request variables
        $limit = $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'));
        //$limitstart = $mainframe->getUserStateFromRequest($option.'.limitstart', 'limitstart', 0);

        //$limitstart = mosGetParam($_REQUEST, 'limitstart', 0);
        // Am I missing something, is this a hack, or an OK solution?
        $limitstart = JRequest::getVar('limitstart',0);

        // In case limit has been changed, adjust it
        $limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);

        $this->setState('limit', $limit);
        $this->setState('limitstart', $limitstart);
    }

    function getTotal()
    {
    // Load the content if it doesn't already exist
        if (empty($this->_total))
        {
            $query = $this->_buildQuery();
            $this->_total = $this->_getListCount($query);
        }
        return $this->_total;
    }

    function getPagination()
    {
    // Load the content if it doesn't already exist
        if (empty($this->_pagination))
        {
            jimport('joomla.html.pagination');

            $total = $this->getTotal();
            $limitstart = $this->getState('limitstart');
            $limit = $this->getState('limit');

            $this->_pagination = new JPagination($total, $limitstart, $limit);
        }
        return $this->_pagination;
    }

    /**
     * Method to delete record(s)
     *
     * @access    public
     * @return    boolean    True on success
     */
    function delete()
    {
        $cids = JRequest :: getVar('cid', array (
            0
            ), 'post', 'array');
        $row = $this->getTable();

        foreach ($cids as $cid)
        {
            if (!$row->delete($cid))
            {
                $this->setError($row->getErrorMsg());
                return false;
            }
        }

        return true;
    }
    function store()
    {
        $row = $this->getTable();

        $data = JRequest :: get('post');

        if (!$row->bind($data))
        {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }

        if (!$row->check())
        {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }

        if (!$row->store())
        {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }

        return true;
    }

    /**
     *
     * Gets Job Type data
     *
     * @return object
     *
     */
    function & getStaticReferral()
    {
        if (!$this->_referral && $this->_id != '')
        {
            $db = $this->getDBO();
            $query = "SELECT * FROM " . $db->quoteName('#__tst_jgapp_static_referral') . " WHERE " .
                $db->quoteName('id') . " = " . $this->_id;
            ;
            $db->setQuery($query);
            $this->_referral = $db->loadObject();
        }
        return $this->_referral;
    }

    function copy()
    {

        $cids = JRequest :: getVar('cid', array (0), 'post', 'array');
        $row = $this->getTable();

        foreach ($cids as $cid)
        {
            $this->_referral = null;
            $this->_id = $cid;
            $tmp = $this->getStaticreferral();
            if (!$tmp)
            {
                $this->setError($row->getErrorMsg());
                return false;
            }
            $tmp->id = null;
            $tmp->status = "Copy of ".$tmp->status;
            $this->save($tmp);

        }
        return true;

    }

    /**
     *
     * Save a Job Type
     *
     */
    function save($data)
    {
        $table = $this->getTable();
        if (!$table->save($data))
        {
            $this->setError($table->getError());
            return false;
        }
        return true;
    }

}
?>