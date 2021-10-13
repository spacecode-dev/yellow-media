<?php

class IndexPageTest extends TestCase
{
    /**
     * @return void
     */
    public function testIndexPageGet()
    {
        $this->get('/');

        $this->assertEquals(
            $this->app->version(), $this->response->getContent()
        );
    }
}
