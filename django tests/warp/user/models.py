from weakref import proxy
from django.db import models
from django.contrib.auth.models import AbstractUser, BaseUserManager
from django.db.models.signals import post_save
from django.dispatch import receiver


class User(AbstractUser):
    class Role(models.TextChoices):
        ADMIN = "ADMIN", "Admin"
        ADOPTER = "ADOPTER", "Adopter"
        SHELTER = "SHELTER", "Shelter"

    base_role = Role.ADMIN

    role = models.CharField(max_length=50, choices=Role.choices)

    def save(self, *args, **kwargs):
        if not self.pk:
            self.role = self.base_role
            return super().save(*args, **kwargs)


# ADOPTER


class AdopterManager(BaseUserManager):
    def get_queryset(self, *args, **kwargs):
        results = super().get_queryset(*args, **kwargs)
        return results.filter(role=User.Role.ADOPTER)


class Adopter(User):

    base_role = User.Role.ADOPTER

    adopter = AdopterManager()

    class Meta:
        proxy = True

    def welcome(self):
        return "Only for adopter"


@receiver(post_save, sender=Adopter)
def create_user_profile(sender, instance, created, **kwargs):
    if created and instance.role == "ADOPTER":
        AdopterProfile.objects.create(user=instance)


class AdopterProfile(models.Model):
    user = models.OneToOneField(User, on_delete=models.CASCADE)
    adopter_id = models.IntegerField(null=True, blank=True)


# SHELTER


class ShelterManager(BaseUserManager):
    def get_queryset(self, *args, **kwargs):
        results = super().get_queryset(*args, **kwargs)
        return results.filter(role=User.Role.SHELTER)


class Shelter(User):

    base_role = User.Role.SHELTER

    shelter = ShelterManager()

    class Meta:
        proxy = True

    def welcome(self):
        return "Only for shelter"

@receiver(post_save, sender=Shelter)
def create_user_profile(sender, instance, created, **kwargs):
    if created and instance.role == "SHELTER":
        ShelterProfile.objects.create(user=instance)


class ShelterProfile(models.Model):
    user = models.OneToOneField(User, on_delete=models.CASCADE)
    shelter_id = models.IntegerField(null=True, blank=True)