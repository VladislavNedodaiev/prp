package com.tnhosh.soundhub.Services.Api.Fingerprint;

import android.annotation.SuppressLint;
import android.app.Activity;
import android.hardware.fingerprint.FingerprintManager;
import android.support.annotation.NonNull;


public abstract class FingerprintApi {
    public interface Callback {
        void onSuccess(String publicKey);

        void onFailure();

        void onError(int errorCode);
    }

    @SuppressLint("NewApi")
    public static FingerprintApi create(@NonNull Activity activity) {
        FingerprintManager fingerprintManager = (FingerprintManager) activity.getSystemService(Activity.FINGERPRINT_SERVICE);
        FingerprintApi api = null;

        try {
            if (fingerprintManager != null && fingerprintManager.isHardwareDetected()) {
                api = MarshmallowFingerprintApi.getInstance(activity);
            }
        } catch (Exception e) {
            e.printStackTrace();
        }

        return api;
    }

    public static final int PERMISSION_FINGERPRINT = 100500; // used for asking permissions

    public abstract boolean isFingerprintSupported();

    public abstract void start(@NonNull Callback callback);

    public abstract void cancel();
}
