<?php

namespace Report;

class  Log
{

    /**
     * Author:Robert Tsang
     *
     * @var mixed
     */
    private $identifier = 'rep';

    /**
     * Author:Robert Tsang
     *
     * @var mixed
     */
    private $repoPath;

    /**
     * Author:Robert Tsang
     *
     * @var mixed
     */
    private $autoPull = true;

    /**
     * Author:Robert Tsang
     *
     * @var mixed
     */
    private $author;


    /**
     * Author:Robert Tsang
     *
     * @var mixed
     */
    private $after;

    /**
     * Author:Robert Tsang
     *
     * @var int|mixed
     */
    private $limit = 5;

    /**
     * Author:Robert Tsang
     *
     * @var mixed|string
     */
    private $project = '';


    /**
     * Generator constructor.
     * @param array $options
     * @throws \Exception
     */
    public function __construct(array $options = [])
    {
        if (isset($options['identifier']) && $options['identifier']) {
            $this->identifier = $options['identifier'];
        }
        if (isset($options['project'])) {
            $this->project = $options['project'];
        }
        if (isset($options['repo_path'])) {
            $this->repoPath = $options['repo_path'];
        }
        if (isset($options['auto_pull'])) {
            $this->autoPull = $options['auto_pull'];
        }
        if (isset($options['author'])) {
            $this->author = $options['author'];
        }
        if (isset($options['after'])) {
            $this->after = $options['after'];
        }
        if (isset($options['limit']) && $options['limit']) {
            $this->limit = intval($options['limit']);
        }
        $this->identifier = $this->identifier ? quotemeta($this->identifier) : '';
    }

    /**
     * Author:Robert
     *
     * @return array
     * @throws \Exception
     */
    public function getDone(): array
    {
        if (!is_dir($this->repoPath.DIRECTORY_SEPARATOR.'.git')) {
            throw new \Exception('git repo "'.$this->repoPath.'" error,PLZ check the configuration file "configs/config.php"');
        }
        chdir($this->repoPath);
        if ($this->autoPull) {
            exec('git pull');
        }
        $cmd = 'git log --pretty=\'%%s\' -i --grep=\'%s\' --author=\'%s\' --after=\'%s\' --date=short -n %s';
        exec(sprintf($cmd, '\['.$this->identifier.'\]\|\['.$this->identifier.':.*\]', $this->author, $this->after, $this->limit), $outputs);
        return $this->parseDone($outputs);
    }

    /**
     * Author:Robert
     *
     * @param array $outputs
     * @return array
     */
    public function parseDone(array $outputs): array
    {
        $data = [];
        foreach ($outputs as $i => $output) {
            if (preg_match('/\['.quotemeta($this->identifier).'\]/i', $output)) {
                $output = preg_replace('/\['.quotemeta($this->identifier).'\]/i', '', $output);
            } elseif (preg_match('/\['.$this->identifier.':(.*)\]/i', $output, $matched)) {
                $output = $matched[1];
            }
            $data[$i] = $this->project.trim(str_replace([PHP_EOL], [''], $output));
        }
        return $data;
    }


}
