<?php
/*
 * This file is part of the cugr package.
 *
 * (c) Bing Liu <liub@mail.bnu.edu.cn>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace App\Library;

use Exception;

class FastaFile
{

    /**
     * construct a fastavalidator Instance
     *
     * @return \FastaValidator
     */
    public function __construct()
    {
    }

    /**
     * Parse a fasta file
     *
     * @return
     */
    public function parseFastaFile($file)
    {
        if (!file_exists($file)) {
            throw new Exception("$file NOT exists", 0);
        }

        $fh = fopen($file, 'r');
        $sequences = array();
        while (!feof($fh)) {
            $tmp = fgets($fh);
            if (preg_match('/^>/', $tmp) && isset($string)) {
                $sequences[] = $this->parseOneSeqString($string);
            } else {
                $string .= $tmp;
            }
        }

        return $sequences;
    }

    /**
     * write fasta to file
     *
     * @return
     */
    public function writeToFile($seq, $file)
    {
        $sequences = $this->parseMulSeqString($seq);
        if (file_exists($file)) {
            throw new Exception("File exists!", 5);
        }
        $data = '';
        foreach ($sequences as $seq) {
            $data .= $seq->description . "\n" . $seq->seq . "\n";
        }
        file_put_contents($file, $data);
    }

    /**
     * Parse multiple sequences of fasta string
     *
     * @return
     */
    public function parseMulSeqString(&$string)
    {
        if (empty($string)) {
            throw new Exception("Empty value provided!", 1);
        }

        $sequences = array();
        $seq_descriptions = array();
        $data = explode("\n", $string);
        foreach ($data as $d) {
            if (preg_match('/^;/', $d) || empty($d)) {
                continue;
            } elseif (preg_match('/^>/', $d)) {
                if (isset($seq)) {
                    $sequences[] = $seq->make();
                }
                if (in_array($d, $seq_descriptions)) {
                    throw new Exception("Duplicated Sequence Found", 5);
                }

                $seq_descriptions[] = $d;
                $seq = new Sequence();
                $seq = $seq->setDescription($d);
            } else {
                if (isset($seq)) {
                    $seq->setSeq($d);
                } else {
                    throw new Exception('Not FASTA format', 2);
                }
            }
        }
        if (isset($seq)) {
            $sequences[] = $seq->make();
        }

        return $sequences;
    }

    /**
     * Parse a fasta string with one sequence
     *
     * @return bool|Sequence instance
     */
    public function parseOneSeqString(&$string)
    {
        $lines = explode("\n", $string);
        $seq = new Sequence();
        foreach ($lines as $line) {
            if (preg_match('/^>/', $line)) {
                $seq->setDescription($line);
            } elseif (preg_match('/^;/', $line)) {
                continue;
            } else {
                $seq->setSeq($line);
            }
        }
        return $seq;
    }
}

class Sequence
{
    /**
     * @var string, the sequence description
     */
    public $description;

    /**
     * @var string, sequences in fragments
     */
    public $seq;

    /**
     * Set $description;
     *
     * @return \Sequence
     */
    public function setDescription($description)
    {
        $description = rtrim(trim($description), '>');
        $this->description = $description;
        return $this;
    }

    /**
     * Set $seq;
     *
     * @return \Sequence
     */
    public function setSeq($seq)
    {
        $seq = preg_replace('/\s*/', '', trim($seq));
        if (!empty($seq)) {
            if (preg_match('/[^a-zA-Z]+/', $seq)) {
                throw new Exception("Illegal character found in sequence", 3);
            }

            $this->seq .= $seq;
        }
        return $this;
    }

    /**
     * Make Sequence
     *
     * @return
     */
    public function make()
    {
        if (empty($this->description) || empty($this->seq)) {
            throw new Exception("Not FASTA format", 4);
        }

        return $this;
    }
}
