function generateCodeVerifier() {
  const array = new Uint32Array(56); // Random 56-character string
  window.crypto.getRandomValues(array);
  return Array.from(array, dec => ('0' + dec.toString(16)).substr(-2)).join('');
}

async function generateCodeChallenge(codeVerifier) {
  const encoder = new TextEncoder();
  const data = encoder.encode(codeVerifier);
  const hashBuffer = await crypto.subtle.digest('SHA-256', data);
  const hashArray = Array.from(new Uint8Array(hashBuffer));
  const base64String = btoa(String.fromCharCode(...hashArray))
      .replace(/\+/g, '-')
      .replace(/\//g, '_')
      .replace(/=+$/, '');
  return base64String;
}

const codeVerifier = generateCodeVerifier();
const codeChallenge = await generateCodeChallenge(codeVerifier);

const authEndpoint = 'https://devauth1.customerpltfm.aig.com/oauth2/ausmgmbyeSo2EHuJs1d6/v1/authorize';
const clientId = '0oaftcvxzeeCm0rk11d7';
const redirectUri = 'http://localhost:8080/';  // The redirect URI after login
const scope = 'SGEwayPartners_IR';
const responseType = 'code';  // PKCE requires this response type

// Build the authorization URL
const authUrl = `${authEndpoint}?response_type=${responseType}&client_id=${clientId}&redirect_uri=${redirectUri}&scope=${scope}&code_challenge=${codeChallenge}&code_challenge_method=S256`;

// Redirect to the authorization server
window.location.href = authUrl;

const urlParams = new URLSearchParams(window.location.search);
const authorizationCode = urlParams.get('code');

async function exchangeCodeForToken(authorizationCode, codeVerifier) {
  const tokenEndpoint = 'https://devauth1.customerpltfm.aig.com/oauth2/ausmgmbyeSo2EHuJs1d6/v1/token';

  const params = new URLSearchParams();
  params.append('grant_type', 'authorization_code');
  params.append('client_id', clientId);
  params.append('redirect_uri', redirectUri);
  params.append('code_verifier', codeVerifier);
  params.append('code', authorizationCode);  // The code from the redirect

  const response = await fetch(tokenEndpoint, {
      method: 'POST',
      headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: params
  });

  if (response.ok) {
      const tokenResponse = await response.json();
      console.log('Access Token:', tokenResponse.access_token);
      return tokenResponse.access_token;
  } else {
      console.error(`Error: ${response.status} - ${response.statusText}`);
      return null;
  }
}

window.onload = async function () {
  const urlParams = new URLSearchParams(window.location.search);
  const authorizationCode = urlParams.get('code');

  if (!authorizationCode) {
      // Step 2: Redirect to authorization server
      const codeChallenge = await generateCodeChallenge(codeVerifier);
      redirectToAuthorizationServer(codeChallenge);
  } else {
      // Step 4: Exchange authorization code for token
      const token = await exchangeCodeForToken(authorizationCode, codeVerifier);
      console.log('Access Token:', token);
  }
};