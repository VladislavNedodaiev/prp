package com.tnhosh.soundhub.Services.Api.Users;

import com.tnhosh.soundhub.Models.User;

import java.util.ArrayList;
import java.util.List;

public class UsersApiImpl implements UsersApi {

    List<User> usersDummy = new ArrayList<>();

    public UsersApiImpl() {
        usersDummy.add(new User(0, "XXXTentacion", "pass1", "https://i.imgur.com/ox97Exk.jpg"));
        usersDummy.add(new User(1, "21 Savage", "pass2", "https://i.imgur.com/ufTAnY2.jpg"));
        usersDummy.add(new User(2, "A$AP Rocky", "pass3", "https://i.imgur.com/hYbkeaD.jpg"));
    }

    @Override
    public User getUserById(int id) {
        return usersDummy.get(id);
    }
}
