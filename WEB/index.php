  <!DOCTYPE html>

  <?php
  include "lib.php";
  $bdd=coBdd();
  ?>
  <html >
    <head>
      <meta charset="UTF-8">
      <title>Dynamic Height</title>
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,400italic">


      <link rel='stylesheet prefetch' href='https://gitcdn.xyz/repo/angular/bower-material/v0.11.4/angular-material.css'>
      <link rel='stylesheet prefetch' href='http://localhost:8080/docs.css'>
      <link rel="stylesheet" href="css/style.css">
      <link rel="stylesheet" href="css/bootstrap.css">
      <link rel="stylesheet" href="css/bootstrap-theme.css">


    </head>

    <body>

      <div ng-app="MyApp" class="tabsdemoDynamicHeight" ng-cloak="">
    <md-content>
      <md-tabs md-dynamic-height="" md-border-bottom="">
        <md-tab label="Lines">
          <md-content class="md-padding">
            <h1 class="md-display-2">Lines</h1>

            <table class="table table-striped">
                    <tbody>
                    <?php
                    if (isset($_GET['path'])) {
                      $line=$_GET['line'];
                      $poids=recupData($line,$_GET['path'], $bdd);

                    }
                    else{

                      if (isset($_GET['line'])) {
                          $path=getPaths($bdd,$_GET['line']);
                          viewPath($path,$_GET['line']);
                      }  
                      else{

                        $lines=getLines($bdd);
                        viewLines2($lines);
                      }
                    }                 


 

                    ?>
              </tbody>
            </table>
          </md-content>
        </md-tab>
        <md-tab label="Community">
          <md-content class="md-padding">
            <h1 class="md-display-2">Community</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla venenatis ante augue. Phasellus volutpat neque ac dui mattis vulputate. Etiam consequat aliquam cursus. In sodales pretium ultrices. Maecenas lectus est, sollicitudin consectetur felis nec, feugiat ultricies mi. Aliquam erat volutpat. Nam placerat, tortor in ultrices porttitor, orci enim rutrum enim, vel tempor sapien arcu a tellus. Vivamus convallis sodales ante varius gravida. Curabitur a purus vel augue ultrices ultricies id a nisl. Nullam malesuada consequat diam, a facilisis tortor volutpat et. Sed urna dolor, aliquet vitae posuere vulputate, euismod ac lorem. Sed felis risus, pulvinar at interdum quis, vehicula sed odio. Phasellus in enim venenatis, iaculis tortor eu, bibendum ante. Donec ac tellus dictum neque volutpat blandit. Praesent efficitur faucibus risus, ac auctor purus porttitor vitae. Phasellus ornare dui nec orci posuere, nec luctus mauris semper.</p>
            <p>Morbi viverra, ante vel aliquet tincidunt, leo dolor pharetra quam, at semper massa orci nec magna. Donec posuere nec sapien sed laoreet. Etiam cursus nunc in condimentum facilisis. Etiam in tempor tortor. Vivamus faucibus egestas enim, at convallis diam pulvinar vel. Cras ac orci eget nisi maximus cursus. Nunc urna libero, viverra sit amet nisl at, hendrerit tempor turpis. Maecenas facilisis convallis mi vel tempor. Nullam vitae nunc leo. Cras sed nisl consectetur, rhoncus sapien sit amet, tempus sapien.</p>
            <p>Integer turpis erat, porttitor vitae mi faucibus, laoreet interdum tellus. Curabitur posuere molestie dictum. Morbi eget congue risus, quis rhoncus quam. Suspendisse vitae hendrerit erat, at posuere mi. Cras eu fermentum nunc. Sed id ante eu orci commodo volutpat non ac est. Praesent ligula diam, congue eu enim scelerisque, finibus commodo lectus.</p>
          </md-content>
        </md-tab>
        <md-tab label="Favorites">
          <md-content class="md-padding">
            <h1 class="md-display-2">Favorites</h1>
            <p>Integer turpis erat, porttitor vitae mi faucibus, laoreet interdum tellus. Curabitur posuere molestie dictum. Morbi eget congue risus, quis rhoncus quam. Suspendisse vitae hendrerit erat, at posuere mi. Cras eu fermentum nunc. Sed id ante eu orci commodo volutpat non ac est. Praesent ligula diam, congue eu enim scelerisque, finibus commodo lectus.</p>
          </md-content>
        </md-tab>
      </md-tabs>
    </md-content>
  </div>
      <script src='https://ajax.googleapis.com/ajax/libs/angularjs/1.4.6/angular.js'></script>
  <script src='https://ajax.googleapis.com/ajax/libs/angularjs/1.4.6/angular-animate.min.js'></script>
  <script src='https://ajax.googleapis.com/ajax/libs/angularjs/1.4.6/angular-route.min.js'></script>
  <script src='https://ajax.googleapis.com/ajax/libs/angularjs/1.4.6/angular-aria.min.js'></script>
  <script src='https://ajax.googleapis.com/ajax/libs/angularjs/1.4.6/angular-messages.min.js'></script>
  <script src='https://gitcdn.xyz/repo/angular/bower-material/v0.11.4/angular-material.js'></script>
  <script src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/t-114/assets-cache.js'></script>



    </body>
  </html>
