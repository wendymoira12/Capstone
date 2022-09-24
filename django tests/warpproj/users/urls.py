from django.urls import path
from . import views

urlpatterns = [
    path('', views.home_guest, name='home-guest')
]
