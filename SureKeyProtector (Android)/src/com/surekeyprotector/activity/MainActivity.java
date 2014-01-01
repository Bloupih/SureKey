package com.surekeyprotector.activity;

import com.surekeyprotector.R;
import com.surekeyprotector.Tasks.ApiCrypter;
import com.surekeyprotector.Tasks.JsonParser;

import android.os.AsyncTask;
import android.os.Bundle;
import android.os.Handler;
import android.app.Activity;
import android.content.Intent;
import android.content.SharedPreferences;
import android.content.pm.ActivityInfo;
import android.content.res.Configuration;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.TextView;

public class MainActivity extends Activity {

	public static final String URI_SERVER = "http://192.168.1.24:8002/Surekey/public/"; // A REMPLACER PAR VOTRE SERVEUR WEB .
	
	final Handler handler = new Handler();
	@Override
	public void onConfigurationChanged(Configuration newConfig) {
	    super.onConfigurationChanged(newConfig);
	    setRequestedOrientation(ActivityInfo.SCREEN_ORIENTATION_PORTRAIT);
	}
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_main);
		
		


		
		final TextView tv1 = (TextView) findViewById(R.id.tv1);
		final String serial = android.os.Build.SERIAL;
		tv1.setText(serial);
		
		Button newcodeButton = (Button) findViewById(R.id.newCode);
		newcodeButton.setOnClickListener(new OnClickListener() {  
			@Override
			public void onClick(View v) {
				
			    SharedPreferences settings = getSharedPreferences(LoginActivity.PARAM_FILE, 0);
			    String pseudo = settings.getString("pseudo", "errno");
			    String pass = settings.getString("pass", "errno");
			    
			    // String devicePass = settings.getString("devicePass", "errno");
			    
			    if(pseudo.equals("errno") || pass.equals("errno"))
			    {
					TextView code = (TextView) findViewById(R.id.code);
					code.setText("Auth erreur");
			    }
			    else
			    {
			    	String url = URI_SERVER+"newPassword?pseudo="+pseudo+"&pass="+pass+"&device="+serial;
			    	Log.w("url" , url);
			    	new getUniquePassword().execute(url);	
			    }
			}
        });
		
		
		try {
		} catch (Exception e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		
		
	}

	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		// Inflate the menu; this adds items to the action bar if it is present.
		getMenuInflater().inflate(R.menu.main, menu);
		return true;
	}
	
	@Override
	public boolean onOptionsItemSelected(MenuItem item) {
	    switch (item.getItemId()) {
	    case R.id.action_showlogin:
	    	
		        Intent intent = new Intent(MainActivity.this, LoginActivity.class);
		        startActivity(intent);
	    	
	        return true;
	    default:
	        return super.onOptionsItemSelected(item);
	    }
	}
	
	
	
	class getUniquePassword extends AsyncTask<String, String,String>{

		private TextView textView;
		
		@Override
		protected String doInBackground(String... params) {
			
			String uri = params[0];
			String data = String.valueOf(JsonParser.getJSON(uri));
			Log.i("data", data);
			
			String serial ="";
			
			// traitement du message retourné.
			if(data.equals("authError"))
			{
				serial="Auth erreur";
			}
			else if(data.equals("deviceError")){
				serial="Device inconnue";
			}
			else if(data.equals("")){
				serial="Erreur serveur...";
			}
			else{
				ApiCrypter apiCrypter = new ApiCrypter(getBaseContext());
				
				try {
					serial = apiCrypter.convertHexToString(ApiCrypter.bytesToHex(apiCrypter.decrypt(data)));
				} catch (Exception e) {
					// TODO Auto-generated catch block
					e.printStackTrace();
				}
			
			}
			return serial;
			

			
		}

		protected void onPostExecute(String serial) {
			textView = (TextView) findViewById(R.id.code);
			textView.setText(serial);
			
	    }


	}
	
	
	
	
	
}




