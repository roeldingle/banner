<?php
class apiSample extends Controller_Api
{
    protected function get($args)
    {
	return $this->post($args);
    }
    
    protected function post($args)
    {
	return $args;
    }
    
    protected function put($args)
    {
	return 'put';
    }
    
    protected function delete($args)
    {
	return 'delete';
    }
}
