package com.example.lunarcalendar.presentation.navigation

sealed class Screen(val route: String) {
    object Daily : Screen("daily")
    object Monthly : Screen("monthly")
}
