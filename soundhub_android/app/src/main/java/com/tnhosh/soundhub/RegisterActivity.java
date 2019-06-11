package com.tnhosh.soundhub;

import android.content.Intent;
import android.content.SharedPreferences;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import com.tnhosh.soundhub.Services.Api.Users.UsersApiImpl;

public class RegisterActivity extends AppCompatActivity {

    Button signUpBtn;
    EditText loginEdit;
    EditText emailEdit;
    EditText passEdit;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_register);
        signUpBtn = findViewById(R.id.sign_up_btn);
        signUpBtn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                signUp(v);
            }
        });

        loginEdit = findViewById(R.id.reg_login_field);
        emailEdit = findViewById(R.id.reg_email_field);
        passEdit = findViewById(R.id.reg_password_field);
    }

    public void signUp(View view) {
        int userId = UsersApiImpl.getInstance().register(loginEdit.getText().toString(), emailEdit.getText().toString(), passEdit.getText().toString());
        if (userId == -10) {
            Toast toast = Toast.makeText(this, "This login already taken", Toast.LENGTH_LONG);
            toast.show();
        } else {
            Intent intent = new Intent(this, FingerprintOfferActivity.class);
            SharedPreferences settings = getSharedPreferences("Account", MODE_PRIVATE);
            SharedPreferences.Editor prefEditor = settings.edit();
            prefEditor.putString("Login", loginEdit.getText().toString());
            prefEditor.putInt("Id", userId);
            //prefEditor.putBoolean("HasFingerprint", true);
            prefEditor.apply();
            finish();
            startActivity(intent);
        }
    }
}
