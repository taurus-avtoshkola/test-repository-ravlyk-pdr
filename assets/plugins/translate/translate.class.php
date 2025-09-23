<?php

class Translate
{

    var $lang_arr;
    var $lang;
    var $modx;
    var $db;
    var $table_lang;
    var $table_content;
    var $table_shop;
    var $replace_lang;

    public function __construct($modx)
    {
        $this->modx     = $modx;
        $this->db       = $modx->db;
        $this->lang     = $this->modx->config['lang_default'];
        $this->lang_arr = explode(',', $this->modx->config['lang_list']);
        $key            = array_search($this->lang, $this->lang_arr);
        unset($this->lang_arr[$key]);
        $this->table_lang    = $this->modx->getFullTableName('a_lang');
        $this->table_content = $this->modx->getFullTableName('site_content');
        $this->table_shop    = $this->modx->getFullTableName('a_product_strings');
        $this->replace_lang  = array('ua' => 'uk', 'dk' => 'da');
    }

    public function setInLang($lang)
    {
        $this->lang = $lang;
    }

    public function setOutLang($lang_arr)
    {
        $this->lang_arr = $lang_arr;
    }


    public function translate_url($lang_to, $text)
    {
        $base_url = 'https://translate.yandex.net/api/v1.5/tr.json/translate';
        $key      = 'trnsl.1.1.20170519T200300Z.ccfc8fcb17ab1df2.b68bf05146dcf8419c6756986df18ce5a66b3aa5';

        if (isset($this->replace_lang[$lang_to])) {
            $lang_to = $this->replace_lang[$lang_to];
        }
        $data['lang'] = 'lang=' . $this->lang . '-' . $lang_to;
        $data['text'] = 'text=' . $text;
        $data['key']  = 'key=' . $key;

        $url = $base_url . '?' . implode('&', $data);
        return $url;
    }


    public function translate($lang_to, $text)
    {
        $base_url = 'https://translate.yandex.net/api/v1.5/tr.json/translate';
        $key      = 'trnsl.1.1.20170519T200300Z.ccfc8fcb17ab1df2.b68bf05146dcf8419c6756986df18ce5a66b3aa5';

        if (isset($this->replace_lang[$lang_to])) {
            $lang_to = $this->replace_lang[$lang_to];
        }
        $data['lang'] = 'lang=' . $this->lang . '-' . $lang_to;
        $data['text'] = 'text=' . urlencode($text);
        $data['key']  = 'key=' . $key;

        $url = $base_url . '?' . implode('&', $data);

        $res     = curl_init();
        $options = array(
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 30,
        );
        curl_setopt_array($res, $options);
        curl_setopt($res, CURLOPT_HTTPHEADER, array("Content-Type: text/xml; charset=utf8"));
        $response = curl_exec($res);
        curl_close($res);
        return $response;
    }

    private function update_lang_file()
    {
        $langs = $this->lang_arr+array($this->lang);
        /*
        $strings = $this->db->query('select * from ' . $this->table_lang . ' order by lang_id asc');
        $f       = fopen(MODX_BASE_PATH . "assets/modules/lang/dump.php", "w");
        fwrite($f, '<?php ' . "\n" . ' $language = Array (' . "\n");
        while ($string = $this->db->getRow($strings)) {
            $write = Array();
            foreach ($langs as $value)
                $write[] = "'" . $value . "' => '" . addslashes($string[$value]) . "'";
            fwrite($f, $string['lang_id'] . " => Array(" . implode(",", $write) . "),\n");
        }
        fwrite($f, ");");
        fclose($f);
*/
        $strings = $this->db->query("select * from " . $this->table_lang . " order by lang_id asc");
        $f       = fopen(MODX_BASE_PATH . "assets/modules/lang/dump.php", "w");
        fwrite($f, '<?php '."\n".'$l=Array(');
        while ($string = $this->db->getRow($strings)) {
           $write = Array();
           //$list  = explode(",", $modx->config['lang_list']);
           foreach ($langs as $value)
                    $write[] = "'".$value."'=>'".addslashes($string[$value])."'";
           fwrite  ($f, $string['lang_id']."=>Array(".implode(",", $write)."),");
        }
        fwrite($f, ");");
        fclose($f);
    }

    public function translate_lang()
    {
        $query    = 'SELECT * FROM ' . $this->table_lang;
        $q_result = $this->db->query($query);
        while ($data = $this->db->getRow($q_result)) {
            $tmp_arr = array();
            foreach ($this->lang_arr as $key => $value) {
                if ($data[$value] != '')
                    continue;

                $response = json_decode($this->translate($value, $data[$this->modx->config['lang_default']]), true);
                $code     = $response['code'];
                $result   = $response['text'][0];
                if ($code == 200) {
                    $tmp_arr[] = $value . ' = "' . $result . '"';
                }
            }
            if (count($tmp_arr) != 0) {
                $query = 'UPDATE ' . $this->table_lang . ' SET ' . implode(', ', $tmp_arr) . ' WHERE lang_id = "' . $data['lang_id'] . '"';
                $this->db->query($query);
            }
        }
        $this->update_lang_file();
    }

    public function translate_content()
    {
        $query    = 'SELECT * FROM ' . $this->table_content;
        $q_result = $this->db->query($query);
        while ($data = $this->db->getRow($q_result)) {
            $tmp_arr = array();
            foreach ($this->lang_arr as $key => $value) {
                if ($data['pagetitle_' . $value] != '' || $data['pagetitle_' . $this->lang] == '')
                    continue;
                $response = json_decode($this->translate($value, $data['pagetitle_' . $this->lang]), true);
                $code     = $response['code'];
                $result   = $response['text'][0];
                if ($code == 200) {
                    $tmp_arr[] = 'pagetitle_' . $value . ' = "' . $this->db->escape($result) . '"';
                }
            }
            if (count($tmp_arr) != 0) {
                $query = 'UPDATE ' . $this->table_content . ' SET ' . implode(', ', $tmp_arr) . ' WHERE id = "' . $data['id'] . '"';
                $this->db->query($query);
            }
        }
    }
}

?>