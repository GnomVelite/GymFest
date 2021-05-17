<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Opret Studiekort</title>
  <link rel="icon" href="assets/favicon-32.png">

  <link type="text/css" rel="stylesheet" href="vendor/dkfds/css/dkfds-virkdk.css" />

</head>

<body>
  <main class="container page-container">
    <div class="row justify-content-center mb-2">
      <div class="col-12">
        <div>
          <h2 class="h2" style="text-align: center;">Opret en bruger og kom i gang!</h2>
        </div>
        <div class="col-sm-6 mx-auto">
          <form method="POST" action="/api/onsite/user/handleSignup.php">
            <div class="form-group">
              <label class="form-label " for="fname">
                Fornavn
              </label>
              <input class="form-input" id="fname" value="" name="fname" type="text" style="max-width: none;">
            </div>
            <div class="form-group">
              <label class="form-label " for="lname">
                Efternavn
              </label>
                <input class="form-input " id="lname" value="" name="lname" type="text" style="max-width: none;">
            </div>
            <div class="form-group">
              <label class="form-label " for="fieldset-email">
                E-mail adresse
              </label>
              <input class="form-input " id="fieldset-email" value="" name="email" type="email" style="max-width: none;">
            </div>
            <div class="form-group">
              <label class="form-label " for="fieldset-password">
                Kodeord
              </label>
              <input class="form-input " id="fieldset-password" value="" name="pass" type="password" style="max-width: none;">
            </div>
            <div style="text-align: center!important">
              <button class="button button-primary mt-9" style="margin: auto;">
                Opret din bruger
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </main>
</body>