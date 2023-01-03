<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Librement inspiré de https://github.com/tchapi/davis/blob/master/src/Controller/DAVController.php
 */
class DavController extends AbstractController
{
    /**
     * Server.
     *
     * @var \Sabre\DAV\Server
     */
    protected $server;

    /**
     * WebDAV Public directory.
     *
     * @var string
     */
    protected $webdavPublicDir;

    /**
     * Public directory of the Symfony installation.
     * Needed to retrieve assets (images).
     *
     * @var string
     */
    protected $publicDir;

    /**
     * WebDAV Temporary directory.
     *
     * @var string
     */
    protected $webdavTmpDir;

    public function __construct(string $publicDir, string $webdavPublicDir, string $webdavTmpDir, UrlGeneratorInterface $router)
    {
        $this->baseUri = $router->generate('dav', ['path' => '']);
        $this->publicDir = $publicDir;
        $this->webdavPublicDir = $webdavPublicDir;
        $this->webdavTmpDir = $webdavTmpDir;
        $nodes[] = new \Sabre\DAV\FS\Directory($this->webdavPublicDir);
        $this->server = new \Sabre\DAV\Server($nodes);
        $this->server->setBaseUri($this->baseUri);
        $this->server->addPlugin(new \Sabre\DAV\Browser\Plugin());
        //locking
        $lockBackend = new \Sabre\DAV\Locks\Backend\File($this->webdavTmpDir.'/locksdb');
        $this->server->addPlugin(new \Sabre\DAV\Locks\Plugin($lockBackend));
        $this->server->addPlugin(new \Sabre\DAV\Browser\GuessContentType());
        $this->server->addPlugin(new \Sabre\DAV\TemporaryFileFilterPlugin($this->webdavTmpDir));
    }

    #[Route('/dav/{path}', name: 'dav', requirements: ["path" => ".*"])]
    public function dav(Request $request, string $path): Response
    {
        ob_start(); // Does not capture headers!
        $this->server->start();

        $output = ob_get_contents();
        ob_end_clean();

        // As previously said, headers are already _prepared_ by the server,
        // so we can't modify them or remove them. But they are not _sent_ yet,
        // so headers_sent() is false, and Symfony will add its own headers above it.
        //
        // The Content-type header is the problem, since Symfony will
        // output `text/html` for everything since it doesn't know any better.
        // Thus, we have to get the _real_ Content-type header already prepared,
        // and force it in the Symfony Response.
        //
        // That's what we do here.
        $response = new Response($output, http_response_code(), []);
        foreach (headers_list() as $header) {
            if ('content-type:' === strtolower(substr($header, 0, 13))) {
                $headerArray = explode(':', $header);
                $response->headers->set('Content-type', $headerArray[1]);
            }
        }

        return $response;
    }
}
