package com.masum.smartcontrol;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.util.Patterns;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;

public class LoginActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);

        final EditText e1 = findViewById(R.id.editText);
        final EditText e2 = findViewById(R.id.editText2);
        Button b1 = findViewById(R.id.button);

        b1.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (e1.length()==0) {
                    e1.setError("Please Enter Email Id");
                } else if (!(Patterns.EMAIL_ADDRESS.matcher(e1.getText().toString()).matches())) {
                    e1.setError("Please Enter Valid Email Id");
                } else if (e2.length()==0) {
                    e2.setError("Please Enter Password");
                } else {
                    LoginBackground loginBackground = new LoginBackground(getApplicationContext());
                    loginBackground.execute(e1.getText().toString(), e2.getText().toString());
                }
            }
        });
    }
}
