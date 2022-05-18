<?php
class Hj_Process_Model_Process_Abstract extends Mage_Core_Model_Abstract
{
	protected $headers = [];
    protected $filedData = [];
    protected $processColumns = [];
    protected $invalidDatas = [];
    protected $requiredColumns = [];
    protected $currentRow = [];
    protected $currentRowTemp = [];
    protected $process = null;

	public function setHeaders($headers)
    {
        $this->headers = $headers;
        return $this;
    }

    public function getHeaders()
    {
        if ($this->headers) {
            return $this->headers;
        }
        return null;
    }

    public function setProcess($process)
    {
        $this->process = $process;
        return $this;
    }

    public function getProcess()
    {
        if ($this->process) {
            return $this->process;
        }
        return null;
    }

    public function setFileDatas($filedData)
    {
        $this->filedData = $filedData;
        return $this;
    }

    public function &getFileDatas()
    {
        if ($this->filedData) {
            return $this->filedData;
        }
        return null;
    }

    public function addFileData($filedData, $key)
    {
        $this->filedData[$key] = $filedData;
        return $this;
    }

    public function getFileData($key)
    {
    	if ($this->filedData[$key]) {
    		return $this->filedData[$key];
    	}
        return null;
    }

    public function setInvalidDatas($invalidDatas)
    {
        $this->invalidDatas = $invalidDatas;
        return $this;
    }

    public function getInvalidDatas()
    {
        if ($this->invalidDatas) {
            return $this->invalidDatas;
        }
        return null;
    }

    public function removeFileData($key)
    {
    	if ($this->filedData[$key]) {
    		unset($this->filedData[$key]);
    	}
        return $this;
    }

    public function addInvalidDatas($invalidData)
    {
        $this->invalidDatas[] = $invalidData;
        return $this;
    }

    public function getCurrentRowTemp()
    {
        if (!$this->currentRowTemp) {
        	$this->currentRowTemp = array_combine(array_keys($this->currentRow), array_fill(0, count($this->currentRow), null));
        }
        return $this->currentRowTemp;
    }

    public function uploadFile()
    {
        $fileName = $this->getFileName();
        $uploader = new Varien_File_Uploader('fileName');
        $uploader->setAllowCreateFolders(true)
        ->setAllowRenameFiles(true)
        ->setAllowedExtensions(['CSV'])
        ->save($this->getFilePath(), $fileName);

        return $fileName;
    }

    public function getFilePath()
    {
        return Mage::getBaseDir('media'). DS .'process'. DS .'import';
    }

    public function downloadSample()
    {
        //$header = array('column_id', 'name', 'sample_value');
        $columnModel = Mage::getModel('process/process_column');
        $name = $this->getFileName();
        $id = $this->getId();
        $select = $columnModel->getCollection()
                ->getSelect()
                ->where('process_id = '. $id)
                ->order('name ASC');
        $columns = $columnModel->getResource()->getReadConnection()->fetchAll($select);
        if (!$columns) {
            throw new Exception("Columns not found.", 1);
        }
        $io = new Varien_Io_File();
        $path = Mage::getBaseDir('var') . DS . 'export';
        $file = $path . DS . $name;
        $io->setAllowCreateFolders(true);
        $io->open(array('path' => $path));
        $io->streamOpen($file, 'w+');
        $io->streamLock(true);
        //$io->streamWriteCsv($header);
        $finalColumn[] = array_column($columns, 'name');
        $finalColumn[] = array_column($columns, 'sample_value');
        $finalColumn[] = array_column($columns, 'required');
        foreach ($finalColumn as $row) {
            $io->streamWriteCsv($row);
        }
        $io->streamUnlock();
        $io->streamClose();
        $csv = [
            'type' => 'file_name',
            'value' => $file,
            'rm' => '1'
        ];
        return $csv;
    }

    public function verify()
    { 
    	$this->readFile();
        $this->validateData();
        $this->processEntry();
        $this->generateInvalidDataReport();
        return true;
    }

    public function readFile()
    {
        $filePathName = $this->getFilePath(). DS .$this->getProcess()->getFileName();
        $handler = fopen($filePathName,"r");
        $headerFlag = false;
        $data = [];
        try{            
            while($row = fgetcsv($handler))
            {
                if ($headerFlag == false) {
                    $this->setHeaders($row);
    		        $this->validateHeaders();
                    $headerFlag = true;
                }
                else
                {
                    $data[] = array_combine($this->getHeaders(), $row);
                }
            }
        }
        catch(Exception $e){
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('process')->__($e->getMessage()));
        }
        $this->setFileDatas($data);
    }

	protected function getRequiredColumns()
    {
        $processColumns = $this->getProcessColumns();
        $requiredColumns = array_map(function ($row)
        {
            if ($row['required'] == 1) {
                return $row['name'];
            }
            return null;
        }, $processColumns);
        return array_filter($requiredColumns);
    }

	protected function getProcessColumns()
    {
        if ($this->processColumns) {
            return $this->processColumns;
        }
        $column = Mage::getModel('process/process_column');
        $select = $column->getCollection()
                        ->getSelect()
                        ->where('process_id = '.$this->getProcess()->getId());
        $this->processColumns = $column->getResource()->getReadConnection()->fetchAll($select);
        return $this->processColumns;
    }

    protected function validateHeaders()
    {
    	try{
	       	$requiredColumns = $this->getRequiredColumns();
	        $invalidHeader = array_diff($requiredColumns, $this->getHeaders());
	        if ($invalidHeader) {
	            throw new Exception("Missing Header".implode(',', $invalidHeader), 1);
	        }
	    }
	    catch(Exception $e){
	    	Mage::getSingleton('adminhtml/session')->addError(Mage::helper('process')->__($e->getMessage()));
	    }
    }

    public function validateData()
    {
        if (!$this->getFileDatas()) {
            throw new Exception("No record available.", 1);
        }
        foreach ($this->getFileDatas() as $key => &$row) {
            try {
            	$this->_validateRow($row);
                $row = $this->validateRow($row);
                $this->_prepareRow($row);
            }
            catch (Exception $e) {
                $this->currentRow['message'] = $e->getMessage();
            	$this->addInvalidDatas($this->currentRow);
                $this->removeFileData($key);
            }
        }
    }

    public function prepareProcessColumn()
    {
    	foreach ($this->getProcessColumns() as $key => $column) {
    		if (in_array($column['name'], $this->getHeaders())) {
    			$processColumns[$column['name']] = $column;
    		}
    	}
    	return $processColumns;
    }

    public function validateRow($row)
    {
    	return $row;
    }

    protected function _validateRow($row)
    {
        $this->currentRow = $row;
        $tempRow = $this->getCurrentRowTemp();
        $processColumns = $this->prepareProcessColumn();
        $invalid = false;
        foreach ($this->currentRow as $key => $value) {
            try {
                if ($key == 'index') {
                	$tempRow[$key] = $value;
                    continue;      
                }
                $this->currentRow[$key] = $this->validateRowData($value, $processColumns[$key]['casting_type'], $processColumns[$key]['required']);
            }
            catch (Exception $e) {
                $invalid = true;
                $tempRow[$key] = $value;
            }
        }
        if ($invalid) {
        	$this->currentRow = $tempRow;
            throw new Exception("Invalid Row.", 1);
        }
        return $this->currentRow;
    }

    public function validateRowData($value, $castingType, $required)
    {
		if ($required == 1) {
            if (empty($value)) {
                throw new Exception("Invalid", 1);
            }
            if ($castingType == 2) {
                if (!$value == (int)$value) {
                    throw new Exception("Invalid", 1);
                }
                return $value;
            }
            elseif($castingType == 3) {
                if ($value == is_numeric($value)) {
                    throw new Exception("Invalid", 1);
                }
                return $value;
            }
        }
        else{
            if (empty($value)) {
                return null;
            }
            if ($castingType == 2) {
                if (!$value == (int)$value) {
                    return null;
                }
                return $value;
            }
            elseif($castingType == 3) {
                if ($value == is_numeric($value)) {
                    return null;
                }
                return $value;
            }
        }
    }

    protected function _prepareRow(&$row)
    {
    	$entry = [
    		'process_id' => $this->getProcess()->getId(),
    		'identifier' => $this->getIdentifier($row),
    		'data' => null
    	];
    	$tableRow = $this->prepareRow($row);
    	$entry['data'] = json_encode($tableRow);
    	$row = $entry; 
    }

    public function prepareRow($row)
    {
    	return $row;
    }

    public function processEntry()
    {
    	$entry = Mage::getModel('process/process_entry');
    	$readConnection = $entry->getResource()->getReadConnection();
        // print_r($this->getFileDatas());
        $readConnection->insertMultiple($entry->getResource()->getTable('process/process_entry'), $this->filedData);
    }

    public function getIdentifier($row)
    {
    	return null;
    }

    public function getJsonData($row)
    {
    	return json_encode($row);
    }

    public function generateInvalidDataReport()
    {
    	$invalid = [];
        $headers = $this->getHeaders();
        array_push($headers, 'message');
    	$invalid[] = $headers;
    	$data = $this->getInvalidDatas();

    	foreach ($data as $key => $value) {
    		$invalid[] = $value;
    	}
    	$csv = new Varien_File_Csv();
    	$csv->saveData($this->getFilePath(). DS . 'invalid.csv', $invalid);
    }


    public function execute()
    {
        $startTime = date('Y-m-d H-m-s');
        $entry = Mage::getModel('process/process_entry');
        $select = $entry->getCollection()
                    ->getSelect()
                    ->where('process_id = ?', $this->getProcess()->getId())
                    ->where('start_time IS NULL')
                    ->limit($this->getProcess()->getPerRequestCount());
        $entries = $entry->getResource()->getReadConnection()->fetchAll($select);
        if (!$entries) {
            throw new Exception("No Entries.", 1);
        }
        $where = 'entry_id IN('.implode(', ',array_column($entries, 'entry_id')).')';

        $updateQuery = Mage::getSingleton('core/resource')->getConnection('core_write');
        $updateQuery->update($entry->getResource()->getMainTable(), ['start_time' => $startTime], $where);
        $this->import($entries);
        $endTime = date('Y-m-d H-m-s');
        $updateQuery->update($entry->getResource()->getMainTable(), ['end_time' => $endTime], $where);
        return $this;
    }

    public function import($entries)
    {
        $sessionVariables = Mage::getSingleton('core/session')->getProcessEntryVariables();
        $processModel = $sessionVariables['processId'];
        foreach ($entries as $key => $entry) 
        {
            $data = json_decode($entry['data'], true);
            $requestModel = Mage::getModel('category/category');
            
            $requestModel->setData($data);
            $save = $requestModel->save();
            if(!$save)
            {
                throw new Exception("Data was not processed", 1);
            }
        }
        return true;
    }

}