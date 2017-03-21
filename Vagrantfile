Vagrant.configure("2") do |config|
  config.vm.box = "debian/contrib-jessie64"
  config.vm.network :forwarded_port, guest: 80, host: 1234
  config.vm.network "private_network", ip:"192.168.33.10"
  config.vm.synced_folder ".", "/home/miga-core/current"
  config.vm.provision :shell, path: "bootstrap.sh"
end
