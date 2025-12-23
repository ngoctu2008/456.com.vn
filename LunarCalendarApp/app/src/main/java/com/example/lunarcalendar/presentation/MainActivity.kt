package com.example.lunarcalendar.presentation

import android.os.Bundle
import androidx.activity.ComponentActivity
import androidx.activity.compose.setContent
import androidx.compose.foundation.layout.fillMaxSize
import androidx.compose.foundation.layout.padding
import androidx.compose.material3.Scaffold
import androidx.compose.material3.MaterialTheme
import androidx.compose.material3.Surface
import androidx.compose.runtime.Composable
import androidx.compose.ui.Modifier
import androidx.navigation.compose.NavHost
import androidx.navigation.compose.composable
import androidx.navigation.compose.rememberNavController
import com.example.lunarcalendar.presentation.daily.DailyCalendarScreen
import com.example.lunarcalendar.presentation.navigation.Screen
import dagger.hilt.android.AndroidEntryPoint

@AndroidEntryPoint
class MainActivity : ComponentActivity() {
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContent {
            MaterialTheme {
                // A surface container using the 'background' color from the theme
                Surface(
                    modifier = Modifier.fillMaxSize(),
                    color = MaterialTheme.colorScheme.background
                ) {
                    LunarCalendarApp()
                }
            }
        }
    }
}

@Composable
fun LunarCalendarApp() {
    val navController = rememberNavController()

    Scaffold { innerPadding ->
        NavHost(
            navController = navController,
            startDestination = Screen.Daily.route,
            modifier = Modifier.padding(innerPadding)
        ) {
            composable(Screen.Daily.route) {
                DailyCalendarScreen()
            }
            composable(Screen.Monthly.route) {
                // Placeholder for Monthly View
                Surface(modifier = Modifier.fillMaxSize()) {
                    androidx.compose.material3.Text("Monthly View Coming Soon")
                }
            }
        }
    }
}
