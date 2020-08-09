package com.masum.smartcontrol;

import androidx.appcompat.app.AppCompatActivity;

import android.os.Bundle;
import android.view.View;
import android.widget.Button;

public class ControlActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_control);

        Button b1 = findViewById(R.id.button3);
        Button b2 = findViewById(R.id.button4);
        Button b3 = findViewById(R.id.button5);
        Button b4 = findViewById(R.id.button6);

        b1.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                ControlBackground controlBackground = new ControlBackground(getApplicationContext());
                controlBackground.execute("1");
            }
        });

        b2.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                ControlBackground controlBackground = new ControlBackground(getApplicationContext());
                controlBackground.execute("2");
            }
        });

        b3.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                ControlBackground controlBackground = new ControlBackground(getApplicationContext());
                controlBackground.execute("3");
            }
        });

        b4.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                ControlBackground controlBackground = new ControlBackground(getApplicationContext());
                controlBackground.execute("4");
            }
        });
    }
}
