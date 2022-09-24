from django.shortcuts import render
from django.http import HttpResponse    

# Create your views here.
def login(request):
    sign_in_email = request.GET.    get('sign-in-email')
    return render(request, 'main/templates/login.html')