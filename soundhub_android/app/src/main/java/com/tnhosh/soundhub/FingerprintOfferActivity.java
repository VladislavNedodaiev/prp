package com.tnhosh.soundhub;

import android.content.DialogInterface;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Handler;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.Toast;

import com.tnhosh.soundhub.Dialogs.FingerprintDialog;
import com.tnhosh.soundhub.Fragments.ProfileFragment;
import com.tnhosh.soundhub.Models.User;
import com.tnhosh.soundhub.Services.Api.Fingerprint.FingerprintApi;
import com.tnhosh.soundhub.Services.Api.Users.UsersApiImpl;

public class FingerprintOfferActivity extends AppCompatActivity implements FingerprintDialog.Callback {

    Button add_fp_btn;
    private FingerprintApi api;
    private FingerprintOfferActivity fpoActivity = this;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_fingerprint_offer);

        add_fp_btn = findViewById(R.id.add_fp_btn);
        //statusView = findViewById(R.id.auth_status);
        checkFingerprintAvailability();
    }

    public void onSkip(View view) {
        Intent intent = new Intent(this, MainActivity.class);
        finish();
        startActivity(intent);
    }

    private void checkFingerprintAvailability() {
        if (isFingerprintSupported()) {
            add_fp_btn.setAlpha(1);
            add_fp_btn.setEnabled(true);
            //statusView.setText("Authorisation isn't done.");
            add_fp_btn.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    FingerprintDialog dialog = FingerprintDialog.getInstance(FingerprintOfferActivity.this);
                    dialog.show(getSupportFragmentManager(), "fingerprint_dialog");
                    api.start(dialog);
                }
            });
        } else {
            add_fp_btn.setAlpha(.5f);
            add_fp_btn.setEnabled(false);
            Toast toast = Toast.makeText(this, "Your device doesn't have a fingerprint sensor.", Toast.LENGTH_LONG);
            toast.show();
        }
    }

    private boolean isFingerprintSupported() {
        // Check for availability and any additional requirements for the api.
        return (api = FingerprintApi.create(this)) != null && api.isFingerprintSupported();
    }

    @Override
    public void onClick(DialogInterface dialog, int which) {
        api.cancel();
        dialog.dismiss();
    }

    @Override
    public void onSuccess(String publicKey) {
        SharedPreferences settings = getSharedPreferences("Account", MODE_PRIVATE);
        String login = settings.getString("Login", "DEFAULT");
        int id = settings.getInt("Id", -10);

        User user = UsersApiImpl.getInstance().getUserById(id);
        user.setCryptoPass(publicKey);
        user.setHasFingerprint(true);


        Handler handler = new Handler();
        handler.postDelayed(new Runnable() {
            @Override
            public void run() {
                Intent intent = new Intent(fpoActivity, MainActivity.class);
                intent.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                SharedPreferences settings = getSharedPreferences("Account", MODE_PRIVATE);
                SharedPreferences.Editor prefEditor = settings.edit();
                prefEditor.putBoolean("HasFingerprint", true);
                prefEditor.apply();
                finish();
                startActivity(intent);
            }
        }, 1100);

    }
}
