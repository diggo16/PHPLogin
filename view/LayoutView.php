<?php


class LayoutView {
  
    /**
     * Echo all the views
     * @param LoginView $v
     * @param DateTimeView $dtv
     */
    public function render(LoginView $v, DateTimeView $dtv, RegisterView $rv) 
    {
        $isLoggedIn = $v->isLoggedIn();
        $registerResponse = $rv->generateTextLink($isLoggedIn);
        $response = $this->getCorrectResponse($v, $rv);
        echo '<!DOCTYPE html>
        <html>
          <head>
            <meta charset="utf-8">
            <title>Login Example</title>
          </head>
          <body>
            <h1>Assignment 2</h1>
            ' . $registerResponse . $this->renderIsLoggedIn($isLoggedIn) . '

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
    private function renderIsLoggedIn($isLoggedIn) {
      if ($isLoggedIn) {
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
        }
        else
        {
            $response = $response = $v->response();
        }
        return $response;
    }
}
