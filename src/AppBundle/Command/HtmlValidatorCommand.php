<?php
/**
 * Created by PhpStorm.
 * User: nico
 * Date: 30/05/18
 * Time: 11:12
 */

namespace AppBundle\Command;

use GuzzleHttp\Client;
use HtmlValidator\Validator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Routing\RouterInterface;

class HtmlValidatorCommand extends Command
{
    /**
     * @var array
     */
    private $routes = [];

    public function __construct(RouterInterface $router)
    {
        $this->routes = $router->getRouteCollection()->all();
        parent::__construct();
    }

    protected function configure()
    {
        $this->addArgument('url');

        $this->setName('app.validateHtml')
             ->setDescription('Validation HTML de certaines pages')
             ->setHelp('Validation HTML de certaines pages');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $client = new Client();

        if (file_exists('var/reports/app.validateHtml.html')) {
            unlink('var/reports/app.validateHtml.html');
        }

        file_put_contents(
            'var/reports/app.validateHtml.html',
            'NB routes tested : '.count($this->routes)."<br />",
            FILE_APPEND
        );

        foreach ($this->routes as $route) {
            if (in_array('GET', $route->getMethods()) && !strstr($route->getPath(), '{')) {
                $res = $client->request('GET', $input->getArgument('url').$route->getPath());
                $content = $res->getBody()->getContents();

                $validator = new Validator();
                $validator->setParser(Validator::PARSER_HTML5);
                $result = $validator->validateDocument($content);

                file_put_contents(
                    'var/reports/app.validateHtml.html',
                    '<strong>'.$route->getPath()."</strong><br />",
                    FILE_APPEND
                );
                file_put_contents(
                    'var/reports/app.validateHtml.html',
                    '<p>'.$result->toHTML().'</p><hr />',
                    FILE_APPEND
                );

                $output->write($result->format());
            }
        }
    }
}
