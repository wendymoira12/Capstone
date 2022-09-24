from django.shortcuts import render
from django.http import HttpResponse

# Create your views here.
def home_guest(request):
    return render(request, 'users/home-guest.html')