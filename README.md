# AutoAssign - MantisBT Plugin

![Version](https://img.shields.io/badge/version-1.0-blue.svg)
![License](https://img.shields.io/badge/license-MIT-green.svg)
![MantisBT](https://img.shields.io/badge/MantisBT-2.0%2B-orange.svg)


**AutoAssign** is a powerful yet simple plugin for [Mantis Bug Tracker (MantisBT)](https://mantisbt.org/) that automates the assignment of issues. It allows you to define rules that automatically assign a specific developer to a reported bug based on the project and the reporter.

## 🚀 How It Works

AutoAssign hooks into the `EVENT_REPORT_BUG` event in MantisBT. When a new bug is reported:
1. The plugin checks the project and the reporter of the new issue.
2. It looks up its defined policy rules to see if there is a mapping for this specific Project + Reporter combination.
3. If a match is found, the bug is automatically assigned to the configured Handler (Developer).
4. An event is logged indicating the automatic assignment.

## 💡 Why Use AutoAssign?

In many workflows, specific developers are responsible for issues coming from specific clients, departments, or testers. Manually assigning every single bug can be tedious and prone to human error.

**AutoAssign solves this by:**
- **Reducing Triage Time:** Bugs land directly in the queue of the right developer immediately after reporting.
- **Improving Response Time:** Developers are notified instantly since they are assigned upon creation.
- **Workflow Consistency:** Ensures that assignments follow your defined team structure without manual intervention.

## 📦 Deployment / Installation

This plugin allows anyone to use it in their MantisBT installation.

### Prerequisites
- MantisBT Core 2.0.0 or higher.

### Installation Steps

1. **Download:** Clone this repository or download the source code.
2. **Deploy:** Copy the `AutoAssign` folder into the `plugins` directory of your MantisBT installation.
   - Path example: `mantisbt/plugins/AutoAssign`
3. **Install:**
   - Log in to MantisBT as an administrator.
   - Navigate to **Manage** > **Manage Plugins**.
   - Find **AutoAssign** in the list of available plugins.
   - Click **Install**.

Once installed, the plugin is active and ready to be configured.

## ⚙️ How to Use

### Configuration

To define your assignment rules:

1. Go to **Manage** > **Manage Plugins**.
2. Click on the **AutoAssign** link to open the configuration page.
3. **Select Project:** exact matching is done per project. Select the relevant project from the dropdown.
4. **Create Rule:**
   - **Reporter:** Select the user who reports the bugs (e.g., a specific QA member or Client user).
   - **Developer:** Select the developer who should receive these bugs.
   - Click **Add Policy**.

### Management
- **View Rules:** Existing rules for the selected project are listed on the configuration page.
- **Delete Rules:** You can remove any obsolete rule by clicking **Delete** next to the entry.

## 🤝 Contribution

We welcome contributions to improve AutoAssign!

1. Fork the repository.
2. Create your feature branch (`git checkout -b feature/NewFeature`).
3. Commit your changes (`git commit -m 'Add some NewFeature'`).
4. Push to the branch (`git push origin feature/NewFeature`).
5. Open a Pull Request.

## 📄 License

This project is open-source and available under the **MIT License**.

You are free to use, modify, and distribute this software, even for commercial purposes.
