package com.tnhosh.soundhub.Dialogs;

import android.annotation.SuppressLint;
import android.app.Activity;
import android.app.AlertDialog;
import android.app.Dialog;
import android.content.DialogInterface;
import android.os.Bundle;
import android.os.Handler;
import android.support.annotation.NonNull;
import android.support.v4.app.DialogFragment;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.ImageView;
import android.widget.TextView;

import com.tnhosh.soundhub.R;
import com.tnhosh.soundhub.Services.Api.Fingerprint.FingerprintApi;

public class FingerprintDialog extends DialogFragment implements FingerprintApi.Callback {
    public interface Callback extends DialogInterface.OnClickListener {
        void onSuccess(String publicKey);
    }

    private Callback listener;
    private ImageView iconView;
    private TextView messageView;

    public static FingerprintDialog getInstance(@NonNull Callback listener) {
        FingerprintDialog dialog = new FingerprintDialog();
        dialog.listener = listener;
        return dialog;
    }

    @NonNull
    @Override
    @SuppressLint("InflateParams")
    @SuppressWarnings("ConstantConditions")
    public Dialog onCreateDialog(Bundle savedInstanceState) {
        Activity activity = getActivity();
        AlertDialog.Builder builder = new AlertDialog.Builder(activity);
        View view = LayoutInflater.from(activity).inflate(R.layout.dialog_fingerprint, null, false);

        iconView = view.findViewById(R.id.dialog_icon);
        messageView = view.findViewById(R.id.dialog_message);

        builder.setView(view)
                .setTitle(R.string.app_name)
                .setNegativeButton(android.R.string.cancel, listener);

        setCancelable(false);
        return builder.create();
    }

    @Override
    public void onSuccess(String publicKey) {
        if (!isActive()) {
            return;
        }

        iconView.setImageResource(R.drawable.ic_fingerprint_success);
        messageView.setText("Authorization was succesfull");
        listener.onSuccess(publicKey);
        dismissWithDelay();
    }

    @Override
    public void onFailure() {
        if (!isActive()) {
            return;
        }

        iconView.setImageResource(R.drawable.ic_fingerprint_failure);
        messageView.setText("Authorization failed");
    }

    @Override
    public void onError(int errorCode) {
        if (!isActive()) {
            return;
        }

        iconView.setImageResource(R.drawable.ic_fingerprint_failure);
        messageView.setText("Authorisation error");

        dismissWithDelay();
    }

    @SuppressWarnings("BooleanMethodIsAlwaysInverted")
    private boolean isActive() {
        return getActivity() != null && !isRemoving() && isAdded();
    }

    private void dismissWithDelay() {
        new Handler().postDelayed(new Runnable() {
            @Override
            public void run() {
                dismiss();
            }
        }, 1000);
    }
}
