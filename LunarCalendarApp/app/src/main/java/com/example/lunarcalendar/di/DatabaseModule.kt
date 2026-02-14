package com.example.lunarcalendar.di

import android.app.Application
import androidx.room.Room
import com.example.lunarcalendar.data.local.AppDatabase
import com.example.lunarcalendar.data.local.dao.UserEventDao
import dagger.Module
import dagger.Provides
import dagger.hilt.InstallIn
import dagger.hilt.components.SingletonComponent
import javax.inject.Singleton

@Module
@InstallIn(SingletonComponent::class)
object DatabaseModule {

    @Provides
    @Singleton
    fun provideAppDatabase(app: Application): AppDatabase {
        return Room.databaseBuilder(
            app,
            AppDatabase::class.java,
            "lunar_calendar.db"
        ).build()
    }

    @Provides
    fun provideUserEventDao(db: AppDatabase): UserEventDao {
        return db.userEventDao()
    }
}
