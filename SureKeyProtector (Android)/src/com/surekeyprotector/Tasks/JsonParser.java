package com.surekeyprotector.Tasks;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.UnsupportedEncodingException;

import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.HttpClient;
import org.apache.http.client.methods.HttpGet;

import android.net.http.AndroidHttpClient;
import android.util.Log;

public class JsonParser {

	public static String getJSON(String infoURI){

		Log.i("getJSON", "entered the function");
		HttpClient httpclient = AndroidHttpClient.newInstance("Android");
		HttpGet httpget = new HttpGet(infoURI);
		// Depends on your web service
		//httpget.setHeader("Content-type", "application/json");

		InputStream inputStream = null;
		String result = "";
		    HttpResponse response = null;
			try {
				response = httpclient.execute(httpget);
			} catch (ClientProtocolException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
				e.getMessage();
			} catch (IOException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
				e.getMessage();
				return "no string";
			}
			
		    HttpEntity entity = response.getEntity();

		    try {
				inputStream = entity.getContent();
			} catch (IllegalStateException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
				e.getMessage();
			} catch (IOException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
				e.getMessage();
			}
		    // json is UTF-8 by default
		    BufferedReader reader = null;
			try {
				reader = new BufferedReader(new InputStreamReader(inputStream, "UTF-8"), 8);
			} catch (UnsupportedEncodingException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
				e.getMessage();
			}
		    StringBuilder sb = new StringBuilder();

		    String line = null;
		    try {
				while ((line = reader.readLine()) != null)
				{
				    sb.append(line + "\n");
				}
			} catch (IOException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
				e.getMessage();
			}
		    result = sb.toString();
			Log.i("result", result);
		    result = result.replaceAll("\"","");
		    result = result.replaceAll("\r","");
		    result = result.replaceAll("\n","");
			Log.i("result traité", result);

		    try{if(inputStream != null)inputStream.close();}catch(Exception squish){}
		    httpget.abort();
		return result;
		
	}
	
}
