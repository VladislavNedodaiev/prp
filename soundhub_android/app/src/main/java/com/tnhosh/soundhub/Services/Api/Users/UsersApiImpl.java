package com.tnhosh.soundhub.Services.Api.Users;

import com.tnhosh.soundhub.Models.User;

import java.util.ArrayList;
import java.util.List;

public class UsersApiImpl implements UsersApi {
    private static UsersApiImpl instance;
    private List<User> usersDummy = new ArrayList<>();

    public static synchronized UsersApiImpl getInstance() {
        if (instance == null) {
            instance = new UsersApiImpl();
        }

        return instance;
    }

    private UsersApiImpl() {
        usersDummy.add(new User(0, "XXXTentacion", "pass1", "https://i.imgur.com/ox97Exk.jpg", null, "tent@mail.com", false));
        usersDummy.add(new User(1, "21 Savage", "pass2", "https://i.imgur.com/ufTAnY2.jpg", null, "savage@mail.com", false));
        usersDummy.add(new User(2, "A$AP Rocky", "pass3", "https://i.imgur.com/hYbkeaD.jpg", null, "a$ap@mail.com", false));
        usersDummy.add(new User(3, "Elias", "password", "", null, "", false));
    }

    @Override
    public User getUserById(int id) {
        return usersDummy.get(id);
    }

    public boolean auth(String login, String password) {
        for (User user : usersDummy) {
            if (user.getLogin().equals(login))  {
                   if (user.getPassword().equals(password) || user.getCryptoPass().equals(password)) {
                       return true;
                   }
            }
        }
        return false;
    }

    public int register(String login, String email, String password) {
        if (isLoginExists(login)) return -10;

        int lastUserId = usersDummy.get(usersDummy.size() - 1).getId();
        User user = new User(lastUserId + 1, login, password, "", null, email, false);
        usersDummy.add(user);
        return user.getId();
    }

    private boolean isLoginExists(String login) {
        for (User user : usersDummy) {
            if (user.getLogin().equals(login)) {
                return true;
            }
        }
        return false;
    }
}
