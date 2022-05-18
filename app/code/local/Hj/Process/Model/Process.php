<?php
class Hj_Process_Model_Process extends Hj_Process_Model_Process_Abstract
{
	const TYPE_ID_IMPORT = 1;
    const TYPE_ID_EXPORT = 2;
    const TYPE_ID_CRON = 3;

    const YES = 1;
    const NO = 2;

    const DECIMAL = 1;
    const INT = 2;
    const VARCHAR = 3;

    protected $headers = [];
    protected $data = [];

	public function _construct()
	{
		$this->_init('process/process');
	}

    public function getTypes()
    {
        $types = [
            self::TYPE_ID_IMPORT => 'IMPORT',
            self::TYPE_ID_EXPORT => 'EXPORT',
            self::TYPE_ID_CRON => 'CRON',
        ];

        if (!$key) {
            return $types;
        }
        if (array_key_exists($key,$types)) {
            return $types[$key];
        }
        return self::TYPE_ID_IMPORT;
    }

}