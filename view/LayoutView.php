<?php


class LayoutView {
  
    private $isLoggedIn = false;
    /**
     * Echo all the views
     * @param LoginView $v
     * @param DateTimeView $dtv
     */
    public function render(LoginView $v, DateTimeView $dtv, RegisterView $rv) 
    {
        $response = $this->getCorrectResponse($v, $rv);
        $registerResponse = $rv->generateTextLink($this->isLoggedIn);
        echo '<!DOCTYPE html>
        <html>
          <head>
            <meta charset="utf-8">
            <title>Login Example</title>
          </head>
          <body>
            <h1>Assignment 2</h1>
            ' . $registerResponse . $this->renderIsLoggedIn() . '

            <div class="container">
                ' . $response . '

                ' . $dtv->show() . '
            </div>
           </body>
        </html>
      ';
    }

    /**
     * 
     * @param boolean $isLoggedIn
     * @return string htmlString
     */
    private function renderIsLoggedIn() {
      if ($this->isLoggedIn) {
        return '<h2>Logged in</h2>';
      }
      else {
        return '<h2>Not logged in</h2>';
      }
    }
    private function getCorrectResponse(LoginView $v, RegisterView $rv)
    {
        $response = "";
        if($rv->isRegisterTextClicked())
        {
            $response = $rv->generateRegisterForm();
            if($response == "")
            {
                $response = $response = $v->response();
                $this->isLoggedIn = $v->isLoggedIn();
            }
        }
        else
        {
            $response = $response = $v->response();
            $this->isLoggedIn = $v->isLoggedIn();
        }
        return $response;
    }
}
