<!DOCTYPE html>
<html>
<head>
<script src="https://cdn.auth0.com/js/lock/10.6.1/lock.min.js"></script>
<script>
  /*var lock = new Auth0Lock(
    "LW1RDBvdFexa2ILhcNRZmTLOgijf0cmD",
    "victorpoeta.auth0.com",
    {
      allowedConnections: ["google-oauth2","twitter"],
      rememberLastLogin: false,
      theme: {"primaryColor":"#40DF7D"},
      languageDictionary: {"title":"Auth0"},
      language: "es",
      auth: { redirect: false },
      responseType: 'code',
    }
  );

  lock.show();
  */
  var lock = new Auth0Lock('LW1RDBvdFexa2ILhcNRZmTLOgijf0cmD', 'victorpoeta.auth0.com', 
    {
    allowedConnections: ["google-oauth2","facebook","windowslive"],
    auth: {
      redirectUrl: "http://localhost:150/auth0_logged",
      responseMode: "form_post",
      responseType: 'token',
      params: {
        scope: 'openid email' // Learn about scopes: https://auth0.com/docs/scopes
      },
      language: "es",
    }
  });

  
</script>
</head>
<body>
<h3>Autenticación mediante Auth0</h3>
<button onclick="lock.show();">Login</button>
</body>
</html>