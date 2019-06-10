package com.tnhosh.soundhub.Models;

public class User {
    private int id;
    private String login;
    private String password;
    private String ImageUrl;

    public User(int id, String login, String password, String imageUrl) {
        this.id = id;
        this.login = login;
        this.password = password;
        ImageUrl = imageUrl;
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

}
