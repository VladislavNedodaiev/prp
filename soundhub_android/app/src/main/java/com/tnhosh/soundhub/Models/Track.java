package com.tnhosh.soundhub.Models;

import java.util.Date;

public class Track {
    private int Id;
    private int UserId;
    private String Name;
    private Date Date;
    private int Length;

    public Track(int id, int userId, String name, java.util.Date date, int length) {
        Id = id;
        UserId = userId;
        Name = name;
        Date = date;
        Length = length;
    }

    public int getId() {
        return Id;
    }

    public void setId(int id) {
        Id = id;
    }

    public int getUserId() {
        return UserId;
    }

    public void setUserId(int userId) {
        UserId = userId;
    }

    public String getName() {
        return Name;
    }

    public void setName(String name) {
        Name = name;
    }

    public java.util.Date getDate() {
        return Date;
    }

    public void setDate(java.util.Date date) {
        Date = date;
    }

    public int getLength() {
        return Length;
    }

    public void setLength(int length) {
        Length = length;
    }
}
