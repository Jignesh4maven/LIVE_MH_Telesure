<?php
#Author : The Guru

class daoParamType
{
	const T_BOOL	=	PDO::PARAM_BOOL;
	const T_NULL	=	PDO::PARAM_NULL;
	const T_INT		=	PDO::PARAM_INT;
	const T_STR		=	PDO::PARAM_STR;
	const T_FLOAT	=	PDO::PARAM_STR;
}

class dao
{
	const moduleName = 'dao';
	private $connection;
	private $command;
	private $transaction;
	private $log;
	private $isLocalTran=true;
	
	function __construct()
	{
		try
		{
			global $connection;
			$this->connection=$connection;
			//$this->connection->setAttribute(PDO::ATTR_TIMEOUT, 30);			
			$this->log=new logger();
		}
		catch(Exception $e)
		{
			$this->log->logIt(dao::moduleName."-"."__construct"."-".$e);
			throw $e;
		}
    }

	function __destruct()
	{
		try
		{
		}
		catch(Exception $e)
		{
			$this->log->logIt(dao::moduleName."-"."__destruct"."-".$e);
			throw $e;
		}
    }
	
	function bindTransaction()
	{
		try
		{
			global $inittran;
			if(!$inittran)
			{
				$this->connection->setAttribute(PDO::ATTR_AUTOCOMMIT,false);				
				$this->connection->beginTransaction();
				$inittran=true;
				$this->isLocalTran=false;
				
			}
		}
		catch(Exception $e)
		{
			$this->log->logIt(dao::moduleName."-"."bindTransaction"."-".$e);
			throw $e;
		}
    }
	
	function releaseTransaction($commit=true)
	{
		try
		{
			global $transaction;
			global $inittran;
			
			if($inittran && (!$this->isLocalTran))
			{
				if($commit)
				{
					$this->connection->commit();
				}
				else
				{
					$this->connection->rollBack();
				}
				$this->connection->setAttribute(PDO::ATTR_AUTOCOMMIT,true);
				$inittran=false;
				$this->isLocalTran=true;
			}
		}
		catch(Exception $e)
		{
			$this->log->logIt(dao::moduleName."-"."releaseTransaction"."-".$e);
			throw $e;
		}
    }
	
	#	PDO::PARAM_BOOL
	#	PDO::PARAM_NULL
	#	PDO::PARAM_INT
	#	PDO::PARAM_STR
	
	function initCommand($strSql)
	{
		try
		{
			$this->command=$this->connection->prepare($strSql);			
		}
		catch(Exception $e)
		{
			$this->log->logIt(dao::moduleName."-"."initCommand"."-QUERY-");
			$this->log->logIt(dao::moduleName."-"."initCommand"."-".$e);
			throw $e;
		}
    }
	
	function addParameter($param,$val)
	{
		try
		{
			$this->command->bindParam($param,$val,PDO::PARAM_STR);
		}
		catch(Exception $e)
		{
			$this->log->logIt(dao::moduleName."-"."addParameter"."-".$e);
			throw $e;
		}
    }
	
	function executeNonQuery()
	{
		try
		{
			$this->command->execute();
		}
		catch(Exception $e)
		{
			$this->log->logIt(dao::moduleName."-"."executeNonQuery"."-QUERY");
			$this->log->logIt(dao::moduleName."-"."executeNonQuery"."-".$e);
			throw $e;
		}
    }

	function executeQuery()
	{
		try
		{
			$this->command->execute();
			$this->command->setFetchMode(PDO::FETCH_ASSOC);
			$rows=$this->command->fetchAll();
			return $rows;
		}
		catch(Exception $e)
		{
			$this->log->logIt(dao::moduleName."-"."executeQuery"."-".$e);
			throw $e;
		}
    }
	
	function executeRow()
	{
		try
		{
			$this->command->execute();
			$this->command->setFetchMode(PDO::FETCH_ASSOC);
			$row=$this->command->fetch();
			$this->command->closeCursor();
			return $row;
		}
		catch(Exception $e)
		{
			$this->log->logIt(dao::moduleName."-"."Exception"."-QUERY-".$e);
			$this->log->logIt($e);
			throw $e;
		}
    }
	
	function executeScalar()
	{
		try
		{
			$this->command->execute();
			$this->command->setFetchMode(PDO::FETCH_ASSOC);
			$value=$this->command->fetchColumn();
			$this->command->closeCursor();
			if(is_resource($value) && get_resource_type($value)==='stream')
				return stream_get_contents($value);
			else
				return $value;
		}
		catch(Exception $e)
		{
			$this->log->logIt(dao::moduleName."-"."executeScalar"."-QUERY");
			$this->log->logIt(dao::moduleName."-"."executeScalar"."-".$e);
			throw $e;
		}
    }

	function getLastInsertedId()
	{
		try
		{
			return $this->connection->lastInsertId();
		}
		catch(Exception $e)
		{
			$this->log->logIt(dao::moduleName."-"."getLastInsertedId"."-".$e);
			throw $e;
		}
	}
}
?>