package com.tnhosh.soundhub.Models;

public class User {
    private int id;
    private String login;
    private String password;
    private String ImageUrl;
    private String cryptoPass;
    private String email;
    private boolean hasFingerprint;

    public User(int id, String login, String password, String imageUrl, String cryptoPass, String email, boolean hasFingerprint) {
        this.id = id;
        this.login = login;
        this.password = password;
        ImageUrl = imageUrl;
        this.cryptoPass = cryptoPass;
        this.email = email;
        this.hasFingerprint = hasFingerprint;
    }

    public String getLogin() {
        return login;
    }

    public void setLogin(String login) {
        this.login = login;
    }

    public String getPassword() {
        return password;
    }

    public void setPassword(String password) {
        this.password = password;
    }

    public String getImageUrl() {
        return ImageUrl;
    }

    public void setImageUrl(String imageUrl) {
        ImageUrl = imageUrl;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getCryptoPass() {
        return cryptoPass;
    }

    public void setCryptoPass(String cryptoPass) {
        this.cryptoPass = cryptoPass;
    }

    public String getEmail() {
        return email;
    }

    public void setEmail(String email) {
        this.email = email;
    }

    public boolean isHasFingerprint() {
        return hasFingerprint;
    }

    public void setHasFingerprint(boolean hasFingerprint) {
        this.hasFingerprint = hasFingerprint;
    }
}
