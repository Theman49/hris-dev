<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
    	if (!in_array(session()->get('data')['userLevel'], ['HR', 'SPV', 'MGR']))
	    {
	    	echo "<script>alert('invalid')</script>";
	        return redirect()->to('/')->with('error', "Not Authorized");
	    }
        // Do something here
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}