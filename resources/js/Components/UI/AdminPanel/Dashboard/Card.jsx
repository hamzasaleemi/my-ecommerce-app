export default function DashboardCard({ title, value, icon, type }) {
    let iconColor = 'bg-gray-500';
    let textColor = 'text-gray-500';
    switch (type) {
        case 'info':
            iconColor = 'bg-blue-500';
            textColor = 'text-blue-500';
            break;
        case 'success':
            iconColor = 'bg-green-500';
            textColor = 'text-green-500';
            break;
        case 'warning':
            iconColor = 'bg-yellow-500';
            textColor = 'text-yellow-500';
            break;
        case 'danger':
            iconColor = 'bg-red-500';
            textColor = 'text-red-500';
            break;
    }
    return (
        <div className="p-4 bg-white border rounded-lg shadow-sm">
            <div className="flex items-center">
                <div className={`p-3 mr-4 text-white ${iconColor} rounded-full`}>
                    {icon}
                </div>
                <div>
                    <h3 className="text-lg font-semibold">{title}</h3>
                    <p className={`text-2xl font-bold ${textColor}`}>{value}</p>
                </div>
            </div>
        </div>
    );
}
