package com.tnhosh.soundhub;

import android.content.DialogInterface;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Handler;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;

import com.tnhosh.soundhub.Dialogs.FingerprintDialog;
import com.tnhosh.soundhub.Fragments.ProfileFragment;
import com.tnhosh.soundhub.Models.User;
import com.tnhosh.soundhub.Services.Api.Fingerprint.FingerprintApi;
import com.tnhosh.soundhub.Services.Api.Users.UsersApiImpl;

public class FingerprintActivity extends AppCompatActivity implements FingerprintDialog.Callback {

    Button fp_btn;
    TextView statusView;
    private FingerprintApi api;
    FingerprintActivity fpActivity = this;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_fingerprint);

        fp_btn = findViewById(R.id.fp_btn);
        statusView = findViewById(R.id.auth_status);

        checkFingerprintAvailability();
    }

    private void checkFingerprintAvailability() {
        if (isFingerprintSupported()) {
            fp_btn.setAlpha(1);
            fp_btn.setEnabled(true);
            fp_btn.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    FingerprintDialog dialog = FingerprintDialog.getInstance(FingerprintActivity.this);
                    dialog.show(getSupportFragmentManager(), "fingerprint_dialog");
                    api.start(dialog);
                }
            });
        } else {
            fp_btn.setAlpha(.5f);
            fp_btn.setEnabled(false);
            statusView.setText("Your device doesn't have a fingerprint sensor.");
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
        int id = settings.getInt("Id", -10);

        User user = UsersApiImpl.getInstance().getUserById(id);
        if (user.getCryptoPass().equals(publicKey)) {
            Handler handler = new Handler();
            handler.postDelayed(new Runnable() {
                @Override
                public void run() {
                    //Intent intent = new Intent(fpActivity, MainActivity.class);
                    //intent.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                    finish();
                    //startActivity(intent);
                }
            }, 1100);
        }
    }
}
