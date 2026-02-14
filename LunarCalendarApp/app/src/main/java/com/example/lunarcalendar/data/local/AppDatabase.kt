package com.example.lunarcalendar.data.local

import androidx.room.Database
import androidx.room.RoomDatabase
import com.example.lunarcalendar.data.local.dao.UserEventDao
import com.example.lunarcalendar.data.local.entity.UserEvent

@Database(entities = [UserEvent::class], version = 1, exportSchema = true)
abstract class AppDatabase : RoomDatabase() {
    abstract fun userEventDao(): UserEventDao
}
