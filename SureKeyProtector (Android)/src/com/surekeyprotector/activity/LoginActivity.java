package com.surekeyprotector.activity;

import com.surekeyprotector.R;
import com.surekeyprotector.Tasks.ApiCrypter;
import com.surekeyprotector.Tasks.JsonParser;

import android.animation.Animator;
import android.animation.AnimatorListenerAdapter;
import android.annotation.TargetApi;
import android.app.Activity;
import android.content.SharedPreferences;
import android.os.AsyncTask;
import android.os.Build;
import android.os.Bundle;
import android.text.TextUtils;
import android.util.Log;
import android.view.Menu;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

/**
 * Activity which displays a login screen to the user, offering registration as
 * well.
 */
public class LoginActivity extends Activity {
	

    public static final String PARAM_FILE = "MyPrefsFile";
	
	/**
	 * A dummy authentication store containing known user names and passwords.
	 * TODO: remove after connecting to a real authentication system.
	 */

	/**
	 * The default email to populate the email field with.
	 */
	public static final String EXTRA_EMAIL = "com.example.android.authenticatordemo.extra.EMAIL";

	/**
	 * Keep track of the login task to ensure we can cancel it if requested.
	 */
	private UserLoginTask mAuthTask = null;

	// Values for email and password at the time of the login attempt.
	private String mPseudo;
	private String mPassword;
	private String mDevice;
	private String mPasswordDevice;
	private String mPasswordCrypt;

	// UI references.
	private EditText mEmailView;
	private EditText mPasswordView;
	private EditText mPasswordDeviceView;
	
	
	private View mLoginFormView;
	private View mLoginStatusView;
	private TextView mLoginStatusMessageView;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);

		
		SharedPreferences settings = getSharedPreferences(LoginActivity.PARAM_FILE, 0);
	    boolean connected = settings.getBoolean("connected", false);
	    
	    if(!connected){
		setContentView(R.layout.activity_login);
		// Set up the login form.
		mPseudo = getIntent().getStringExtra(EXTRA_EMAIL);
		mEmailView = (EditText) findViewById(R.id.email);
		mEmailView.setText(mPseudo);

		mPasswordView = (EditText) findViewById(R.id.password);
		mPasswordDeviceView = (EditText) findViewById(R.id.passwordDevice);
		/* mPasswordView
				.setOnEditorActionListener(new TextView.OnEditorActionListener() {
					@Override
					public boolean onEditorAction(TextView textView, int id,
							KeyEvent keyEvent) {
						if (id == R.id.login || id == EditorInfo.IME_NULL) {
							attemptLogin();
							return true;
						}
						return false;
					}
				});
		*/

		mLoginFormView = findViewById(R.id.login_form);
		mLoginStatusView = findViewById(R.id.login_status);
		mLoginStatusMessageView = (TextView) findViewById(R.id.login_status_message);

		findViewById(R.id.sign_in_button).setOnClickListener(
				new View.OnClickListener() {
					@Override
					public void onClick(View view) {
						attemptLogin();
					}
				});
		
	    }
	    else{
			setContentView(R.layout.activity_logout);
			Button disconnectButton = (Button)findViewById(R.id.disconnect_button);
			disconnectButton.setOnClickListener(new View.OnClickListener() {
					@Override
					public void onClick(View view) {
						getBaseContext().getSharedPreferences(LoginActivity.PARAM_FILE, 0).edit().clear().commit();
						Toast.makeText(getBaseContext(), "Déconnecté !", Toast.LENGTH_LONG).show();
						finish();
					}
				});
	    }
	}

	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		super.onCreateOptionsMenu(menu);
		getMenuInflater().inflate(R.menu.login, menu);
		return true;
	}

	/**
	 * Attempts to sign in or register the account specified by the login form.
	 * If there are form errors (invalid email, missing fields, etc.), the
	 * errors are presented and no actual login attempt is made.
	 */
	public void attemptLogin() {
		if (mAuthTask != null) {
			return;
		}

		// Reset errors.
		mEmailView.setError(null);
		mPasswordView.setError(null);

		// Store values at the time of the login attempt.
		mPseudo = mEmailView.getText().toString();
		mPassword = mPasswordView.getText().toString();
		mPasswordDevice = mPasswordDeviceView.getText().toString();
		
		boolean cancel = false;
		View focusView = null;

		// Check for a valid password.
		if (TextUtils.isEmpty(mPassword)) {
			mPasswordView.setError(getString(R.string.error_field_required));
			focusView = mPasswordView;
			cancel = true;
		} else if (mPassword.length() < 4) {
			mPasswordView.setError(getString(R.string.error_invalid_password));
			focusView = mPasswordView;
			cancel = true;
		}

		
		// Check for a valid key 
		if (TextUtils.isEmpty(mPasswordDevice)) {
			mPasswordView.setError(getString(R.string.error_field_required));
			focusView = mPasswordDeviceView;
			cancel = true;
		} else if (mPasswordDevice.length() < 16) {
			mPasswordView.setError("16 char");
			focusView = mPasswordDeviceView;
			cancel = true;
		}

		
		
		// Check for a valid email address.
		if (TextUtils.isEmpty(mPseudo)) {
			mEmailView.setError(getString(R.string.error_field_required));
			focusView = mEmailView;
			cancel = true;
		}
		
		if (cancel) {
			// There was an error; don't attempt login and focus the first
			// form field with an error.
			focusView.requestFocus();
		} else {
			// Show a progress spinner, and kick off a background task to
			// perform the user login attempt.
			mLoginStatusMessageView.setText(R.string.login_progress_signing_in);
			showProgress(true);
			mDevice = android.os.Build.SERIAL;
			
			//cryptage

			//ApiCrypter.secretkey = mPasswordDeviceView.getText().toString();
			ApiCrypter apiCrypter = new ApiCrypter(getBaseContext(), mPasswordDeviceView.getText().toString());
			
			try {
				mPasswordCrypt = ApiCrypter.bytesToHex(apiCrypter.encrypt(mPassword));
			} catch (Exception e1) {
				// TODO Auto-generated catch block
				mPasswordCrypt="fail";
				e1.printStackTrace();
			}
			// fin cryptage
			Log.e("crypted pass", mPasswordCrypt);
			
			
			String url = MainActivity.URI_SERVER+"verifyConnection?pseudo="+mPseudo+"&pass="+mPasswordCrypt+"&device="+mDevice;

			Log.e("url", url);
			// debug : String url = "http://192.168.1.24:8002/Surekey/public/verifyConnection?pseudo=admin&pass=admin&device=4790f041cd3abf94";
			mAuthTask = new UserLoginTask();
			mAuthTask.execute(url);
		}
	}

	/**
	 * Shows the progress UI and hides the login form.
	 */
	@TargetApi(Build.VERSION_CODES.HONEYCOMB_MR2)
	private void showProgress(final boolean show) {
		// On Honeycomb MR2 we have the ViewPropertyAnimator APIs, which allow
		// for very easy animations. If available, use these APIs to fade-in
		// the progress spinner.
		if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.HONEYCOMB_MR2) {
			int shortAnimTime = getResources().getInteger(
					android.R.integer.config_shortAnimTime);

			mLoginStatusView.setVisibility(View.VISIBLE);
			mLoginStatusView.animate().setDuration(shortAnimTime)
					.alpha(show ? 1 : 0)
					.setListener(new AnimatorListenerAdapter() {
						@Override
						public void onAnimationEnd(Animator animation) {
							mLoginStatusView.setVisibility(show ? View.VISIBLE
									: View.GONE);
						}
					});

			mLoginFormView.setVisibility(View.VISIBLE);
			mLoginFormView.animate().setDuration(shortAnimTime)
					.alpha(show ? 0 : 1)
					.setListener(new AnimatorListenerAdapter() {
						@Override
						public void onAnimationEnd(Animator animation) {
							mLoginFormView.setVisibility(show ? View.GONE
									: View.VISIBLE);
						}
					});
		} else {
			// The ViewPropertyAnimator APIs are not available, so simply show
			// and hide the relevant UI components.
			mLoginStatusView.setVisibility(show ? View.VISIBLE : View.GONE);
			mLoginFormView.setVisibility(show ? View.GONE : View.VISIBLE);
		}
	}

	/**
	 * Represents an asynchronous login/registration task used to authenticate
	 * the user.
	 */
	public class UserLoginTask extends AsyncTask<String, String, String> {


		protected String doInBackground(String... params) {
			// TODO: attempt authentication against a network service.

			String data = "" ;
			String uri = params[0];
			data = JsonParser.getJSON(uri);
			
			// traitement du message retourné.
			data = data.trim();
			if(String.valueOf(data).equals("0")){
				data = "Connection error";
			}
			else if(String.valueOf(data).equals("1")){

				data = "OK";
				
				// on ecrit le login , le pass et la passkey dans les settings permanentes.
				SharedPreferences settings = getSharedPreferences(PARAM_FILE, 0);
			    SharedPreferences.Editor editor = settings.edit();
			    editor.putString("pseudo", mPseudo);
			    editor.putString("pass", mPasswordCrypt);
			    editor.putString("devicePass", mPasswordDevice);
			    editor.putBoolean("connected", true);
			    editor.commit();

			}
			
			return data;
		}

		protected void onPostExecute(final String success) {
			mAuthTask = null;
			showProgress(false);
			

			
			
			
			
			if (success == "OK") {
				Toast.makeText(getApplicationContext(), "Connecté !", Toast.LENGTH_LONG ).show();
				finish();
			} else {
				
				Toast.makeText(getApplicationContext(), "Erreur de connexion ! success : "+success, Toast.LENGTH_LONG ).show();
				mPasswordView
						.setError(getString(R.string.error_incorrect_password));
				mPasswordView.requestFocus();
			}
		}

		@Override
		protected void onCancelled() {
			mAuthTask = null;
			showProgress(false);
		}
	}
}
