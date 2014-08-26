# -*- mode: ruby -*-

VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|

  config.vm.box = "f500/debian-wheezy64"
  config.vm.box_check_update = false

  config.vm.network "private_network", ip: "192.168.138.10"

  config.vm.provider :virtualbox do |vb|
    vb.name = "kotta"
  end

  config.vm.provision :ansible do |ansible|
    ansible.inventory_path = "ansible/hosts"
    ansible.playbook       = "ansible/provision.yml"
    ansible.limit          = "vagrant"
  end

end
