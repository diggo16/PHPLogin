<?php


class LayoutView {
  /**
   * Echo all the views
   * @param LoginView $v
   * @param DateTimeView $dtv
   */
  public function render(LoginView $v, DateTimeView $dtv) 
  {
      $response = $v->response();
      $isLoggedIn = $v->isLoggedIn();
      echo '<!DOCTYPE html>
      <html>
        <head>
          <meta charset="utf-8">
          <title>Login Example</title>
        </head>
        <body>
          <h1>Assignment 2</h1>
          ' . $this->renderIsLoggedIn($isLoggedIn) . '
          
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
  private function renderIsLoggedIn(boolean $isLoggedIn) {
    if ($isLoggedIn) {
      return '<h2>Logged in</h2>';
    }
    else {
      return '<h2>Not logged in</h2>';
    }
  }
}
