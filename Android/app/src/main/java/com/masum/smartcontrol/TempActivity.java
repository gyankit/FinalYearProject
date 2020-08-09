package com.masum.smartcontrol;

import android.annotation.SuppressLint;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

public class TempActivity extends AppCompatActivity {

    int tempInC = 0, tempInF = 0, humidity = 0;
    TextView t1, t2, t3;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_temp);

        t1 = findViewById(R.id.textView);
        t2 = findViewById(R.id.textView2);
        t3 = findViewById(R.id.textView3);
        Button b1 = findViewById(R.id.button);
        Button b2 = findViewById(R.id.button2);

        TempBackground tempBackground = new TempBackground(TempActivity.this);
        tempBackground.execute();

        b1.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                finish();
                overridePendingTransition(0, 0);
                startActivity(getIntent());
                overridePendingTransition(0, 0);
            }
        });

        b2.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent i = new Intent(TempActivity.this, ControlActivity.class);
                startActivity(i);
            }
        });

    }

    @SuppressLint("SetTextI18n")
    void returnData(String data) throws JSONException {
        JSONObject jsonData = new JSONObject(data);
        tempInC = Integer.parseInt(jsonData.getString("temp"));
        tempInF = ((tempInC * 9) / 5) + 32;
        humidity = Integer.parseInt(jsonData.getString("humd"));

        if (tempInC >= 35) {
            t1.setTextColor(this.getResources().getColor(R.color.pink));
            t2.setTextColor(this.getResources().getColor(R.color.pink));
        } else if(tempInC >= 25) {
            t1.setTextColor(this.getResources().getColor(R.color.yellow));
            t2.setTextColor(this.getResources().getColor(R.color.yellow));
        } else {
            t1.setTextColor(this.getResources().getColor(R.color.green));
            t2.setTextColor(this.getResources().getColor(R.color.green));
        }
        t1.setText(tempInC+" °C");
        t2.setText(tempInF+" °F");
        t3.setText(humidity+" %");
    }
}
