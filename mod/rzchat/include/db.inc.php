<?php
/**
 * @version 1.0
 * @copyright Copyright (C) 2014 rayzzz.com. All rights reserved.
 * @license GNU/GPL2, see LICENSE.txt
 * @website http://rayzzz.com
 * @twitter @rayzzzcom
 * @email rayzexpert@gmail.com
 */
class RzDbConnect
{
    var $bPrintLog;

    var $sHost;
    var $iPort;
    var $iSocket;
    var $sDb;
    var $sUser;
    var $sPassword;
    var $bConnected;
    var $rLink;

    function RzDbConnect($sHost, $iPort, $iSocket, $sDb, $sUser, $sPassword)
    {
        $this->bPrintLog = true;
        $this->sHost = $sHost;
        $this->iPort = $iPort;
        $this->iSocket = $iSocket;
        $this->sDb = $sDb;
        $this->sUser = $sUser;
        $this->sPassword = $sPassword;

        $this->bConnected = false;
    }

    function connect()
    {
        if($this->bConnected) return;
        $dbHost = strlen($this->iPort) ? $this->sHost . ":" . $this->iPort : $this->sHost;
        $dbHost .= strlen($this->iSocket) ? ":" . $this->iSocket : "";
        @$this->rLink = mysql_connect($dbHost, $this->sUser, $this->sPassword);
        if($this->rLink)
			$this->bConnected = true;
        else
			$this->bConnected = false;
        @mysql_select_db($this->sDb, $this->rLink);
        mysql_query("SET NAMES 'utf8'", $this->rLink);
        mysql_query("SET @@local.wait_timeout=9000;", $this->rLink);
        mysql_query("SET @@local.interactive_timeout=9000;", $this->rLink);
    }

    function disconnect()
    {
        mysql_close($this->rLink);
        $this->bConnected = false;
    }

    function reconnect()
    {
        $this->disconnect();
        $this->connect();
    }

    function getResult($sQuery)
    {
        if(!$this->bConnected || !($rResult = mysql_query($sQuery, $this->rLink))) {
            echo 'Database access error.';
            if($this->bPrintLog === true) echo " Description: " . mysql_error($this->rLink);
            return false;
        }

        return $rResult;
    }

    function getArray($sQuery)
    {
        if(!$this->bConnected || !($rResult = mysql_query($sQuery, $this->rLink))) {
            echo 'Database access error.';
            if($this->bPrintLog === true) echo " Description: " . mysql_error($this->rLink);
            return false;
        }

        return mysql_fetch_array($rResult);
    }

    function getValue($sQuery)
    {
        if(!$this->bConnected || !($rResult = mysql_query( $sQuery, $this->rLink))) {
            echo 'Database access error.';
            if($this->bPrintLog === true) echo " Description: " . mysql_error($this->rLink);
            return false;
        } else {
            $aResult = mysql_fetch_array($rResult);
            return $aResult[0];
        }
    }

    function getLastInsertId()
    {
        return mysql_insert_id($this->rLink);
    }
	
	function getNumRows($rResult)
    {
        return mysql_num_rows($rResult);
    }
	
	function fetch($rResult)
    {
        return mysql_fetch_assoc($rResult);
    }
}